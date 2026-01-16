<?php

namespace App\Http\Controllers;

use App\Services\VNPayService;
use Illuminate\Http\Request;

class VNPayDebugController extends Controller
{
    /**
     * Hiển thị cấu hình VNPay (chỉ dùng cho development)
     */
    public function config()
    {
        if (!app()->isLocal()) {
            abort(403, 'This endpoint is only available in local environment');
        }

        return response()->json([
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
            'vnpay_config' => [
                'tmn_code' => config('vnpay.tmn_code'),
                'payment_url' => config('vnpay.payment_url'),
                'query_url' => config('vnpay.query_url'),
                'refund_url' => config('vnpay.refund_url'),
                'app_url' => config('vnpay.app_url'),
                'hash_secret_length' => strlen(config('vnpay.hash_secret')),
            ],
            'notes' => 'Endpoint này chỉ hoạt động ở development environment',
        ]);
    }

    /**
     * Test tạo URL thanh toán
     */
    public function testCreatePaymentUrl(Request $request)
    {
        if (!app()->isLocal()) {
            abort(403);
        }

        $vnpayService = app(VNPayService::class);

        $paymentUrl = $vnpayService->createPaymentUrl([
            'amount' => 100000, // 100,000 VND
            'order_info' => 'Test Payment #' . now()->timestamp,
            'txn_ref' => $vnpayService->generateTransactionRef(),
            'return_url' => route('payment.return'),
        ]);

        return response()->json([
            'payment_url' => $paymentUrl,
            'redirect_url' => '<a href="' . $paymentUrl . '">Click to pay</a>',
        ]);
    }

    /**
     * Test xác minh response
     */
    public function testVerifyResponse(Request $request)
    {
        if (!app()->isLocal()) {
            abort(403);
        }

        $vnpayService = app(VNPayService::class);

        // Mock response từ VNPay
        $mockData = [
            'vnp_Amount' => 100000 * 100,
            'vnp_BankCode' => 'NCB',
            'vnp_BankTranNo' => '20260116123456',
            'vnp_CardType' => 'ATM',
            'vnp_OrderInfo' => 'Test Payment',
            'vnp_PayDate' => date('YmdHis'),
            'vnp_ResponseCode' => '00',
            'vnp_TmnCode' => config('vnpay.tmn_code'),
            'vnp_TransactionNo' => '14009348',
            'vnp_TxnRef' => 'ORD20260116123456XXX',
        ];

        // Tạo chữ ký
        ksort($mockData);
        $hashData = '';
        foreach ($mockData as $key => $value) {
            if ($value != "") {
                $hashData .= '&' . $key . "=" . urlencode($value);
            }
        }
        $hashData = ltrim($hashData, '&');
        $mockData['vnp_SecureHash'] = hash_hmac('sha512', $hashData, config('vnpay.hash_secret'));

        // Xác minh
        $verification = $vnpayService->verifyPaymentResponse($mockData);

        return response()->json([
            'mock_data' => $mockData,
            'verification_result' => $verification,
            'is_valid' => $verification['is_valid'],
        ]);
    }

    /**
     * Test tạo mã giao dịch
     */
    public function testGenerateTransactionRef()
    {
        if (!app()->isLocal()) {
            abort(403);
        }

        $vnpayService = app(VNPayService::class);

        return response()->json([
            'transaction_refs' => [
                $vnpayService->generateTransactionRef(),
                $vnpayService->generateTransactionRef(),
                $vnpayService->generateTransactionRef(),
            ],
        ]);
    }

    /**
     * Kiểm tra kết nối đến VNPay
     */
    public function testConnection()
    {
        if (!app()->isLocal()) {
            abort(403);
        }

        try {
            $response = \Http::get(config('vnpay.payment_url'), [
                'vnp_TmnCode' => config('vnpay.tmn_code'),
            ]);

            return response()->json([
                'status' => 'ok',
                'message' => 'VNPay server is reachable',
                'response_status' => $response->status(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'error_class' => class_basename($e),
            ], 500);
        }
    }
}
