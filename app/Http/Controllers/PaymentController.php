<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Services\VNPayService;
use App\Events\PaymentCompleted;
use App\Events\PaymentFailed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class PaymentController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    /**
     * Tạo URL thanh toán VNPay
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Kiểm tra quyền
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.show', $order->id)->with('error', 'Không có quyền thanh toán đơn hàng này');
        }

        // Tạo mã giao dịch
        $txnRef = $this->vnpayService->generateTransactionRef();

        // Cập nhật order với transaction_id
        $order->update([
            'payment_method' => 'vnpay',
            'transaction_id' => $txnRef,
        ]);

        // Tạo URL thanh toán
        $paymentUrl = $this->vnpayService->createPaymentUrl([
            'amount' => $order->total_amount,
            'order_info' => 'Thanh toán đơn hàng #' . $order->id,
            'txn_ref' => $txnRef,
            'return_url' => route('payment.return'),
        ]);

        return redirect()->to($paymentUrl);
    }

    /**
     * Xử lý callback từ VNPay
     */
    public function handleReturn(Request $request)
    {
        try {
            $data = $request->all();
            
            // Log for debugging
            \Log::info('VNPay Return Data:', $data);
            
            $verification = $this->vnpayService->verifyPaymentResponse($data);
            
            // Log verification result
            \Log::info('VNPay Verification:', $verification);

            if (!$verification['is_valid']) {
                \Log::error('VNPay signature verification failed');
                return redirect()->route('payment.failed')->with('error', 'Chữ ký thanh toán không hợp lệ');
            }

            $order = Order::where('transaction_id', $verification['transaction_code'])->first();

            if (!$order) {
                \Log::error('Order not found for transaction: ' . $verification['transaction_code']);
                return redirect()->route('payment.failed')->with('error', 'Không tìm thấy đơn hàng');
            }

        // Kiểm tra mã phản hồi từ VNPay
        if ($verification['response_code'] == '00') {
            // Thanh toán thành công
            $order->update([
                'status' => 'completed',
                'payment_status' => 'completed',
                'transaction_date' => now(),
                'vnp_bank_code' => $data['vnp_BankCode'] ?? null,
                'vnp_card_type' => $data['vnp_CardType'] ?? null,
                'vnp_transaction_no' => $data['vnp_TransactionNo'] ?? null,
                'vnp_response_code' => $data['vnp_ResponseCode'] ?? null,
            ]);

            // Clear Cart items for this user since payment is successful
            CartItem::where('user_id', $order->user_id)->delete();

            // Dispatch event
            PaymentCompleted::dispatch($order);

            // Gửi email xác nhận
            try {
                Mail::to($order->customer_email)->send(new OrderPlaced($order));
                $admin = \App\Models\User::whereHas('roles', function($q) {
                    $q->where('name', 'admin');
                })->first();
                if ($admin) {
                    Mail::to($admin->email)->send(new OrderPlaced($order));
                }
            } catch (\Exception $e) {
                // Log error if needed
            }

            return redirect()->route('payment.success', $order->id);
        } else {
            // Thanh toán thất bại
            $order->update([
                'payment_status' => 'failed',
            ]);

            // Dispatch event
            PaymentFailed::dispatch($order, $data['vnp_Message'] ?? 'Lỗi không xác định');

            return redirect()->route('payment.failed')->with('error', 'Thanh toán thất bại: ' . ($data['vnp_Message'] ?? 'Lỗi không xác định'));
        }
        } catch (\Exception $e) {
            \Log::error('VNPay handleReturn error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('payment.failed')->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán');
        }
    }

    /**
     * Trang thành công
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Kiểm tra quyền
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.history')->with('error', 'Không có quyền xem đơn hàng này');
        }

        return view('payment.success', compact('order'));
    }

    /**
     * Trang thất bại
     */
    public function failed()
    {
        return view('payment.failed');
    }

    /**
     * Xem trạng thái giao dịch
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Kiểm tra quyền
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$order->transaction_id) {
            return response()->json(['status' => 'no_transaction']);
        }

        // Query VNPay để kiểm tra trạng thái
        $result = $this->vnpayService->queryTransaction(
            $order->transaction_id,
            $order->transaction_date ? $order->transaction_date->format('YmdHis') : now()->format('YmdHis')
        );

        return response()->json($result);
    }

    /**
     * Yêu cầu hoàn tiền
     */
    public function requestRefund(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Kiểm tra quyền
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Chỉ hoàn tiền nếu thanh toán đã hoàn tất và đơn hàng chưa giao
        if ($order->payment_status !== 'completed' || in_array($order->status, ['shipped', 'completed', 'cancelled'])) {
            return response()->json(['error' => 'Không thể hoàn tiền cho đơn hàng này'], 400);
        }

        if (!$order->transaction_id || !$order->transaction_date) {
            return response()->json(['error' => 'Không tìm thấy thông tin giao dịch'], 400);
        }

        // Gọi hoàn tiền VNPay
        $result = $this->vnpayService->refundTransaction(
            $order->transaction_id,
            $order->transaction_date->format('YmdHis'),
            $order->total_amount
        );

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        // Cập nhật trạng thái đơn hàng
        $order->update([
            'status' => 'refunded',
            'payment_status' => 'refunded',
        ]);

        // Dispatch event
        PaymentFailed::dispatch($order, 'Đã được hoàn tiền theo yêu cầu');

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu hoàn tiền đã được gửi',
            'result' => $result,
        ]);
    }
}
