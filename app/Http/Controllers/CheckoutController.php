<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Jobs\SendOrderCompletedNotification;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            $courses = Auth::user()->cartItems()->with('course.category')->get()->pluck('course');
        } else {
            $cart = session('cart', []);
            $courses = Course::whereIn('id', $cart)->with('category')->get();
        }

        $total = $courses->sum(function($c){ return $c->sale_price ?? $c->price; });

        return view('checkout', compact('courses','total'));
    }

    public function addToCart(Request $request, Course $course)
    {
        if (Auth::check()) {
            CartItem::updateOrCreate([
                'user_id' => Auth::id(),
                'course_id' => $course->id
            ]);
        } else {
            $cart = session('cart', []);
            if (!in_array($course->id, $cart)) {
                $cart[] = $course->id;
                session(['cart' => $cart]);
            }
        }
        
        return redirect()->route('checkout.show');
    }

    public function removeFromCart(Course $course)
    {
        if (Auth::check()) {
            Auth::user()->cartItems()->where('course_id', $course->id)->delete();
        } else {
            $cart = session('cart', []);
            $cart = array_values(array_filter($cart, function($id) use ($course) {
                return $id != $course->id;
            }));
            session(['cart' => $cart]);
        }

        return redirect()->route('checkout.show');
    }

    public function process(CheckoutRequest $request)
    {
        $user = Auth::user();
        
        if (Auth::check()) {
            $courses = $user->cartItems()->with('course')->get()->pluck('course');
        } else {
            $cart = session('cart', []);
            $courses = Course::whereIn('id', $cart)->get();
        }

        if ($courses->isEmpty()) {
            return redirect()->route('home')->with('status', 'Giỏ hàng trống.');
        }

        // Prevention of COD spam and duplicate purchases
        if (Auth::check()) {
            foreach ($courses as $course) {
                // 1. Check if already purchased
                if ($user->hasPurchased($course)) {
                    return redirect()->route('checkout.show')->with('error', "Bạn đã sở hữu khóa học '{$course->title}' rồi.");
                }

                // 2. Check for pending COD orders to prevent spam
                if ($request->payment_method === 'cod') {
                    $existingPendingOrder = Order::where('user_id', $user->id)
                        ->where('payment_method', 'cod')
                        ->whereIn('status', ['awaiting', 'pending', 'shipping'])
                        ->whereHas('items', function($query) use ($course) {
                            $query->where('course_id', $course->id);
                        })
                        ->exists();

                    if ($existingPendingOrder) {
                        return redirect()->route('checkout.show')->with('error', "Bạn đã có một đơn hàng COD đang chờ xử lý cho khóa học '{$course->title}'. Bạn có thể <a href='" . route('profile.orders') . "'>vào đây</a> để đổi hình thức thanh toán.");
                    }
                }
            }
        }

        $total = $courses->sum(function($c){ return $c->sale_price ?? $c->price; });

        $order = Order::create([
            'user_id' => $user ? $user->id : null, // Handle guest checkout if allowed, though usually auth is required
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'awaiting',
        ]);

        foreach ($courses as $course) {
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $course->sale_price ?? $course->price,
            ]);
        }

        if ($request->payment_method === 'vnpay') {
            $rounded = (int) (ceil($total / 1000) * 1000);
            $order->update(['total_price' => $rounded]);

            return $this->createVNPayPayment($order);
        }

        if ($request->payment_method === 'cod') {
            Log::info("New COD order created #{$order->id} for user: " . ($user ? $user->email : 'Guest') . ". Awaiting admin confirmation.");
            
            // Send COD notification email
            try {
                \App\Jobs\SendCODOrderNotification::dispatchSync($order);
            } catch (\Throwable $e) {
                Log::error("Failed to send COD order notification: " . $e->getMessage());
            }

            if (Auth::check()) {
                $user->cartItems()->delete();
            } else {
                session()->forget('cart');
            }

            return redirect()->route('home')->with('status', 'Đơn hàng đã được đặt thành công! Vui lòng chờ Admin xác nhận thanh toán để bắt đầu học.');
        }
        
        if (Auth::check()) {
            $user->cartItems()->delete();
        } else {
            session()->forget('cart');
        }
        return redirect()->route('home')->with('status', 'Đơn hàng đặt thành công!');
    }

    protected function createVNPayPayment(Order $order)
    {
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_Returnurl = config('vnpay.vnp_Returnurl');
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');

        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $order->id;
        $vnp_OrderType = 'billpayment';
        // Ensure amount is an integer VND and convert to VNPay expected unit
        $amountInt = (int) round($order->total_price);
        $vnp_Amount = $amountInt * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        if ($vnp_IpAddr == '::1') {
            $vnp_IpAddr = '127.0.0.1';
        }

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect()->away($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        
        // Log payment response for debugging
        Log::info('VNPAY return received', [
            'order_id' => $request->vnp_TxnRef,
            'response_code' => $request->vnp_ResponseCode,
            'amount' => $request->vnp_Amount,
            'transaction_no' => $request->vnp_TransactionNo,
        ]);
        
        if ($secureHash == $vnp_SecureHash) {
            // Payment signature is valid
            if ($request->vnp_ResponseCode == '00') {
                // Payment successful
                $order = Order::find($request->vnp_TxnRef);
                
                if ($order && $order->status !== 'completed') {
                    $order->update(['status' => 'completed']);
                    
                    // Attach courses to user
                    $user = $order->user;
                    $courseIds = $order->items->pluck('course_id')->toArray();
                    $user->courses()->syncWithoutDetaching($courseIds);

                    // Dispatch email job to notify user
                    Log::info("VNPAY payment successful for order #{$order->id}. Sending confirmation email to {$user->email}");
                    try {
                        \App\Jobs\SendOrderCompletedNotification::dispatch($order);
                        Log::info("Email job dispatched for VNPAY order #{$order->id}");
                    } catch (\Throwable $e) {
                        Log::error("Failed to dispatch email job for VNPAY order #{$order->id}: " . $e->getMessage());
                    }
                    
                    if (Auth::check()) {
                        Auth::user()->cartItems()->delete();
                    }
                    session()->forget('cart');
                    return redirect()->route('home')->with('status', 'Thanh toán VNPay thành công! Email xác nhận đã được gửi đến địa chỉ email của bạn.');
                }
            } else {
                // Payment failed
                Log::warning("VNPAY payment failed for order #{$request->vnp_TxnRef}. Response code: {$request->vnp_ResponseCode}");
                return redirect()->route('home')->with('error', 'Thanh toán VNPay không thành công. Vui lòng thử lại.');
            }
        } else {
            // Invalid signature
            Log::error("VNPAY signature validation failed for order #{$request->vnp_TxnRef}");
            return redirect()->route('home')->with('error', 'Thanh toán VNPay không hợp lệ. Vui lòng liên hệ hỗ trợ.');
        }
        
        return redirect()->route('home')->with('error', 'Có lỗi xảy ra trong quá trình thanh toán VNPay.');
    }

    public function changePaymentMethod(Request $request, Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow changing from COD if it's still awaiting/pending
        if ($order->payment_method === 'cod' && in_array($order->status, ['awaiting', 'pending'])) {
            $order->update(['payment_method' => 'vnpay']);
            
            // Round up for VNPay if needed (matching original process logic)
            $total = $order->total_price;
            $rounded = (int) (ceil($total / 1000) * 1000);
            $order->update(['total_price' => $rounded]);

            return $this->createVNPayPayment($order);
        }

        return redirect()->back()->with('error', 'Không thể đổi phương thức thanh toán cho đơn hàng này.');
    }
}

