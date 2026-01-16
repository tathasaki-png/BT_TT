# VNPay Code Snippets - Các đoạn code thường dùng

## 📌 Mục Lục

1. [Service Usage](#service-usage)
2. [Controller Examples](#controller-examples)
3. [View Examples](#view-examples)
4. [Helper Usage](#helper-usage)
5. [Event Listeners](#event-listeners)
6. [Query Examples](#query-examples)
7. [Blade Template Snippets](#blade-template-snippets)

---

## 🔧 Service Usage

### Lấy VNPayService Instance

```php
use App\Services\VNPayService;

// Trong controller
class MyController extends Controller
{
    protected $vnpayService;
    
    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }
    
    public function test()
    {
        // Sử dụng service
    }
}

// Hoặc sử dụng helper
$vnpayService = \App\Helpers\PaymentHelper::vnpay();
```

### Tạo URL Thanh Toán

```php
$paymentUrl = $vnpayService->createPaymentUrl([
    'amount' => 1000000,                    // 1 triệu đồng
    'order_info' => 'Thanh toán đơn hàng',
    'txn_ref' => 'ORD20260116123456XXX',
    'return_url' => route('payment.return'),
    'bank_code' => 'NCB',                   // Optional
]);

// Redirect
return redirect()->to($paymentUrl);
```

### Xác Minh Response

```php
$verification = $vnpayService->verifyPaymentResponse($request->all());

if (!$verification['is_valid']) {
    return redirect()->route('payment.failed')->with('error', 'Invalid signature');
}

$isSuccess = $verification['response_code'] == '00';
```

### Query Giao Dịch

```php
$result = $vnpayService->queryTransaction(
    'ORD20260116123456XXX',  // Transaction ref
    '20260116123456'          // Transaction date (YmdHis)
);

echo $result['TransactionStatus'];  // Success, Failed, Processing, etc
```

### Hoàn Tiền

```php
$result = $vnpayService->refundTransaction(
    'ORD20260116123456XXX',  // Transaction ref
    '20260116123456',         // Transaction date
    1000000                   // Amount to refund
);

if ($result['success']) {
    echo 'Refund approved';
} else {
    echo 'Refund failed: ' . $result['error'];
}
```

---

## 📋 Controller Examples

### Full Payment Controller Example

```php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\VNPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function createPayment(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        
        $txnRef = $this->vnpayService->generateTransactionRef();
        $order->update(['transaction_id' => $txnRef]);
        
        $paymentUrl = $this->vnpayService->createPaymentUrl([
            'amount' => $order->total_amount,
            'order_info' => "Order #{$order->id}",
            'txn_ref' => $txnRef,
            'return_url' => route('payment.return'),
        ]);
        
        return redirect()->to($paymentUrl);
    }

    public function handleReturn(Request $request)
    {
        $verification = $this->vnpayService->verifyPaymentResponse($request->all());
        
        if (!$verification['is_valid']) {
            return redirect()->route('payment.failed');
        }
        
        $order = Order::where('transaction_id', $verification['transaction_code'])->first();
        
        if ($verification['response_code'] == '00') {
            $order->update([
                'status' => 'completed',
                'payment_status' => 'completed',
            ]);
            
            return redirect()->route('payment.success', $order->id);
        } else {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('payment.failed');
        }
    }
}
```

### Custom Order Controller Logic

```php
// Tạo đơn hàng với phương thức thanh toán
public function placeOrder(Request $request)
{
    $request->validate([
        'payment_method' => 'required|in:direct,vnpay',
    ]);

    $order = Order::create([
        'user_id' => auth()->id(),
        'payment_method' => $request->payment_method,
        'payment_status' => 'pending',
        // ... other fields
    ]);

    if ($request->payment_method === 'direct') {
        // Thanh toán trực tiếp
        $order->update(['status' => 'completed']);
        return redirect()->route('orders.history');
    }

    // Chuyển hướng đến VNPay
    return redirect()->route('payment.create', $order->id);
}
```

---

## 🎨 View Examples

### Checkout Form với Radio Buttons

```blade
<div class="payment-methods">
    <div class="form-check">
        <input type="radio" name="payment_method" value="direct" checked>
        <label>
            <strong>Thanh toán khi nhận hàng</strong>
            <small>Trả tiền khi nhân viên giao</small>
        </label>
    </div>
    
    <div class="form-check">
        <input type="radio" name="payment_method" value="vnpay">
        <label>
            <strong>Thanh toán qua VNPay</strong>
            <small>Thẻ ngân hàng, ví điện tử</small>
        </label>
    </div>
</div>
```

### Hiển Thị Trạng Thái Thanh Toán

```blade
@if($order->payment_method)
    <div class="payment-info">
        <p>
            <strong>Phương thức:</strong>
            {{ \App\Helpers\PaymentHelper::getPaymentMethodLabel($order->payment_method) }}
        </p>
        
        <p>
            <strong>Trạng thái:</strong>
            <span class="badge {{ \App\Helpers\PaymentHelper::getPaymentStatusBadgeClass($order->payment_status) }}">
                {{ \App\Helpers\PaymentHelper::getPaymentStatusLabel($order->payment_status) }}
            </span>
        </p>
        
        @if($order->transaction_id)
            <p>
                <strong>Mã giao dịch:</strong> {{ $order->transaction_id }}
            </p>
        @endif
    </div>
@endif
```

### Nút Thanh Toán/Hoàn Tiền

```blade
@if(\App\Helpers\PaymentHelper::canPayOrder($order))
    <form action="{{ route('payment.create') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-credit-card"></i> Thanh toán ngay
        </button>
    </form>
@elseif(\App\Helpers\PaymentHelper::canRefundOrder($order))
    <button onclick="requestRefund({{ $order->id }})" class="btn btn-danger">
        <i class="fas fa-undo"></i> Yêu cầu hoàn tiền
    </button>
@endif
```

---

## 🛠️ Helper Usage

### Kiểm Tra Quyền Thanh Toán

```php
use App\Helpers\PaymentHelper;

// Kiểm tra có thể thanh toán
if (PaymentHelper::canPayOrder($order)) {
    // Hiển thị nút thanh toán
}

// Kiểm tra có thể hoàn tiền
if (PaymentHelper::canRefundOrder($order)) {
    // Hiển thị nút hoàn tiền
}
```

### Format Tiền

```php
// Tính tiền cho VNPay (nhân 100)
$vnpayAmount = PaymentHelper::formatAmount(100000); // 10000000

// Hiển thị tiền cho user
echo number_format($order->total_amount, 0, '.', ',') . ' ₫';
```

### Lấy Labels

```php
// Payment status
PaymentHelper::getPaymentStatusLabel('completed');     // "Đã thanh toán"
PaymentHelper::getPaymentStatusLabel('pending');       // "Chưa thanh toán"
PaymentHelper::getPaymentStatusLabel('failed');        // "Thanh toán thất bại"
PaymentHelper::getPaymentStatusLabel('refunded');      // "Đã hoàn tiền"

// Payment method
PaymentHelper::getPaymentMethodLabel('direct');        // "Thanh toán khi nhận hàng"
PaymentHelper::getPaymentMethodLabel('vnpay');         // "VNPay"

// Badge class
PaymentHelper::getPaymentStatusBadgeClass('completed'); // "bg-success"
PaymentHelper::getPaymentStatusBadgeClass('pending');   // "bg-warning"
```

---

## 🎯 Event Listeners

### Lắng Nghe Payment Events

```php
// app/Providers/EventServiceProvider.php
protected $listen = [
    'App\Events\PaymentCompleted' => [
        'App\Listeners\SendPaymentConfirmation',
    ],
    'App\Events\PaymentFailed' => [
        'App\Listeners\NotifyAdminPaymentFailed',
    ],
];
```

### Tạo Event Listeners

```php
// Listener khi thanh toán thành công
namespace App\Listeners;

use App\Events\PaymentCompleted;

class SendPaymentConfirmation
{
    public function handle(PaymentCompleted $event)
    {
        // Gửi email xác nhận
        \Mail::to($event->order->customer_email)
            ->send(new OrderPlaced($event->order));

        // Log
        \Log::info('Payment completed for order', [
            'order_id' => $event->order->id,
            'amount' => $event->order->total_amount,
        ]);

        // Gửi SMS (optional)
        // SmsService::send($event->order->customer_phone, 'Payment confirmed');
    }
}

// Listener khi thanh toán thất bại
namespace App\Listeners;

use App\Events\PaymentFailed;

class NotifyAdminPaymentFailed
{
    public function handle(PaymentFailed $event)
    {
        // Thông báo admin
        \Mail::to(config('mail.from.address'))
            ->send(new PaymentFailedNotification($event->order, $event->errorMessage));

        // Alert
        \Log::warning('Payment failed', [
            'order_id' => $event->order->id,
            'reason' => $event->errorMessage,
        ]);
    }
}
```

---

## 📊 Query Examples

### Lấy Doanh Thu

```php
// Tổng doanh thu
$revenue = Order::where('payment_status', 'completed')
    ->sum('total_amount');

// Doanh thu hôm nay
$todayRevenue = Order::where('payment_status', 'completed')
    ->whereDate('created_at', today())
    ->sum('total_amount');

// Doanh thu theo phương thức
$vnpayRevenue = Order::where('payment_method', 'vnpay')
    ->where('payment_status', 'completed')
    ->sum('total_amount');

$directRevenue = Order::where('payment_method', 'direct')
    ->where('payment_status', 'completed')
    ->sum('total_amount');
```

### Lấy Thống Kê Thanh Toán

```php
// Số lần thanh toán thành công
$successCount = Order::where('payment_status', 'completed')->count();

// Số lần thanh toán thất bại
$failedCount = Order::where('payment_status', 'failed')->count();

// Tỷ lệ thành công
$successRate = Order::where('payment_method', 'vnpay')
    ->where('payment_status', 'completed')
    ->count() / 
    Order::where('payment_method', 'vnpay')->count() * 100;

// Tỷ lệ hoàn tiền
$refundRate = Order::where('payment_status', 'refunded')->count() / 
    Order::where('payment_status', 'completed')->count() * 100;
```

### Lấy Giao Dịch VNPay

```php
// Tất cả giao dịch VNPay
$vnpayTransactions = Order::where('payment_method', 'vnpay')->get();

// Giao dịch VNPay thành công
$vnpaySuccess = Order::where('payment_method', 'vnpay')
    ->where('payment_status', 'completed')
    ->get();

// Tìm giao dịch bằng transaction ID
$order = Order::where('transaction_id', 'ORD20260116...')->first();

// Giao dịch trong ngày
$todayTransactions = Order::where('payment_method', 'vnpay')
    ->whereDate('transaction_date', today())
    ->get();
```

---

## 🎨 Blade Template Snippets

### Success Page

```blade
<div class="alert alert-success">
    <h3>✅ Thanh toán thành công!</h3>
    <p>Đơn hàng #{{ $order->id }} đã được xác nhận</p>
    <p>Tổng tiền: {{ number_format($order->total_amount, 0, '.', ',') }} ₫</p>
    <p>Email: {{ $order->customer_email }}</p>
</div>
```

### Failed Page

```blade
<div class="alert alert-danger">
    <h3>❌ Thanh toán thất bại</h3>
    <p>{{ session('error', 'Có lỗi xảy ra') }}</p>
    <a href="{{ route('checkout') }}" class="btn btn-primary">Thử lại</a>
</div>
```

### Payment Status Badge

```blade
@php
    $statusMap = [
        'pending' => ['color' => 'warning', 'text' => 'Chưa thanh toán'],
        'completed' => ['color' => 'success', 'text' => 'Đã thanh toán'],
        'failed' => ['color' => 'danger', 'text' => 'Thất bại'],
        'refunded' => ['color' => 'secondary', 'text' => 'Đã hoàn'],
    ];
    $status = $statusMap[$order->payment_status] ?? ['color' => 'secondary', 'text' => 'N/A'];
@endphp

<span class="badge bg-{{ $status['color'] }}">
    {{ $status['text'] }}
</span>
```

### Order List with Payment Info

```blade
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ number_format($order->total_amount, 0, '.', ',') }} ₫</td>
                <td>
                    <span class="badge bg-info">
                        {{ $order->payment_method === 'vnpay' ? 'VNPay' : 'Direct' }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-{{ $order->payment_status === 'completed' ? 'success' : 'warning' }}">
                        {{ $order->payment_status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No orders</td>
            </tr>
        @endforelse
    </tbody>
</table>
```

---

## 💡 Pro Tips

### 1. Idempotent Callback
```php
// Lưu transaction_id trước khi redirect
$order->update(['transaction_id' => $txnRef]);

// Check trong callback
if (Order::where('transaction_id', $txnRef)->exists()) {
    // Giao dịch đã được xử lý
    return response()->json(['success' => true]);
}
```

### 2. Retry Logic
```php
$attempt = 0;
$maxAttempts = 3;

while ($attempt < $maxAttempts) {
    try {
        $result = $vnpayService->queryTransaction($txnRef, $transDate);
        break;
    } catch (\Exception $e) {
        $attempt++;
        sleep(2 ^ $attempt); // Exponential backoff
    }
}
```

### 3. Webhook Security
```php
// Verify IP
$vnpayIps = ['180.93.255.224/28', '180.93.255.240/28'];

if (!ipInRange(request()->ip(), $vnpayIps)) {
    abort(403, 'IP not whitelisted');
}

// Verify timestamp (trong 15 phút)
if (abs(now()->diffInSeconds($request->timestamp)) > 900) {
    abort(401, 'Timestamp invalid');
}
```

### 4. Rate Limiting
```php
// Giới hạn số lần try payment
Route::middleware('throttle:3,1')->group(function () {
    Route::post('/payment/create', [...]);
});
```

---

**Happy Coding!** 🚀
