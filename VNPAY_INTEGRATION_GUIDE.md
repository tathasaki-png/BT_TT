# Hướng Dẫn Tích Hợp VNPay Payment Gateway

## Giới Thiệu
Tích hợp VNPay payment gateway vào hệ thống đặt hàng của bạn, cho phép khách hàng thanh toán trực tuyến qua thẻ ngân hàng hoặc ví điện tử.

## Các File Được Tạo/Sửa Đổi

### 1. Config File
- **`config/vnpay.php`** - Cấu hình VNPay (TMN Code, Hash Secret, URLs)

### 2. Service Class
- **`app/Services/VNPayService.php`** - Service xử lý tất cả các thao tác VNPay:
  - Tạo URL thanh toán
  - Xác minh response từ VNPay
  - Query giao dịch
  - Hoàn tiền

### 3. Controller
- **`app/Http/Controllers/PaymentController.php`** - Controller xử lý:
  - Tạo URL thanh toán
  - Xử lý callback từ VNPay
  - Kiểm tra trạng thái thanh toán
  - Yêu cầu hoàn tiền

### 4. Database Migration
- **`database/migrations/2026_01_16_000000_add_payment_fields_to_orders_table.php`**
  - Thêm các trường: `payment_method`, `payment_status`, `transaction_id`, `transaction_date`

### 5. Models
- **`app/Models/Order.php`** - Cập nhật fillable với các trường thanh toán mới

### 6. Routes
- **`routes/web.php`** - Thêm các route thanh toán:
  - `POST /payment/create` - Tạo URL thanh toán
  - `GET /payment/return` - Callback từ VNPay
  - `GET /payment/success/{orderId}` - Trang thành công
  - `GET /payment/failed` - Trang thất bại
  - `POST /payment/check-status` - Kiểm tra trạng thái
  - `POST /payment/refund` - Hoàn tiền

### 7. Views
- **`resources/views/orders/checkout.blade.php`** - Cập nhật với lựa chọn phương thức thanh toán
- **`resources/views/orders/show.blade.php`** - Cập nhật hiển thị trạng thái thanh toán
- **`resources/views/payment/success.blade.php`** - Trang thành công thanh toán
- **`resources/views/payment/failed.blade.php`** - Trang thất bại thanh toán

## Cấu Hình VNPay

### Bước 1: Đăng Ký VNPay
1. Truy cập [https://sandbox.vnpayment.vn](https://sandbox.vnpayment.vn) (sandbox test) hoặc live
2. Đăng ký tài khoản merchant
3. Lấy **TMN Code** và **Hash Secret**

### Bước 2: Cấu Hình .env
Thêm vào file `.env`:
```env
VNPAY_TMN_CODE=your_tmn_code_here
VNPAY_HASH_SECRET=your_hash_secret_here

# Sandbox (mặc định, dùng để test)
VNPAY_PAYMENT_URL=https://sandbox.vnpayment.vn/paygate
VNPAY_QUERY_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction
VNPAY_REFUND_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction/refund

# Production (khi chạy live, sử dụng URLs này)
# VNPAY_PAYMENT_URL=https://payment.vnpayment.vn/paygate
# VNPAY_QUERY_URL=https://api.vnpayment.vn/merchant_webapi/api/transaction
# VNPAY_REFUND_URL=https://api.vnpayment.vn/merchant_webapi/api/transaction/refund
```

### Bước 3: Chạy Migration
```bash
php artisan migrate
```

## Luồng Thanh Toán

### 1. Khách Hàng Chọn Phương Thức Thanh Toán
- Tại trang checkout, khách hàng có 2 lựa chọn:
  - Thanh toán khi nhận hàng (Direct)
  - Thanh toán qua VNPay

### 2. Nếu Chọn VNPay
- Đơn hàng được tạo với `payment_status = 'pending'`
- Khách được chuyển hướng đến `PaymentController::createPayment()`
- URL thanh toán được tạo và redirect sang VNPay

### 3. Khách Hàng Thanh Toán
- Khách hàng nhập thông tin thẻ hoặc ví trên VNPay
- VNPay xử lý thanh toán

### 4. VNPay Trả Về Kết Quả
- VNPay gọi callback URL: `/payment/return`
- Ứng dụng xác minh chữ ký (HMAC SHA512)
- Nếu thành công: Cập nhật `order.status = 'completed'` và `payment_status = 'completed'`
- Gửi email xác nhận

### 5. Khách Hàng Thấy Trang Kết Quả
- Thành công: `/payment/success/{orderId}` - hiển thị thông tin đơn hàng
- Thất bại: `/payment/failed` - yêu cầu thử lại

## Các Tính Năng

### 1. Tạo Thanh Toán
```php
PaymentController::createPayment($order_id)
```

### 2. Xử Lý Callback
```php
PaymentController::handleReturn($request)
```
- Xác minh chữ ký VNPay
- Cập nhật trạng thái đơn hàng
- Gửi email xác nhận

### 3. Kiểm Tra Trạng Thái
```php
POST /payment/check-status
{
    "order_id": 1
}
```
- Query VNPay để lấy thông tin giao dịch mới nhất

### 4. Hoàn Tiền
```php
POST /payment/refund
{
    "order_id": 1
}
```
- Yêu cầu hoàn tiền từ VNPay
- Cập nhật `order.status = 'refunded'` và `payment_status = 'refunded'`

## VNPayService - Các Method

### `createPaymentUrl(array $data)`
Tạo URL thanh toán
```php
$url = $vnpayService->createPaymentUrl([
    'amount' => 1000000, // 1 triệu đồng
    'order_info' => 'Thanh toán đơn hàng #1',
    'txn_ref' => 'ORD20260116123456XXX',
    'return_url' => route('payment.return'),
    'bank_code' => '' // Optional: Mã ngân hàng cụ thể
]);
```

### `verifyPaymentResponse(array $data)`
Xác minh response từ VNPay
```php
$verification = $vnpayService->verifyPaymentResponse($request->all());
// Returns: ['is_valid' => bool, 'response_code' => string, ...]
```

### `queryTransaction(string $txnRef, string $transDate)`
Lấy thông tin giao dịch
```php
$result = $vnpayService->queryTransaction('ORD20260116123456XXX', '20260116123456');
```

### `refundTransaction(string $txnRef, string $transDate, int $amount)`
Hoàn tiền
```php
$result = $vnpayService->refundTransaction('ORD20260116123456XXX', '20260116123456', 1000000);
```

### `generateTransactionRef()`
Tạo mã giao dịch duy nhất
```php
$txnRef = $vnpayService->generateTransactionRef(); // ORD202601161234567XXXXX
```

## Mã Phản Hồi VNPay

### Response Code
- `00` - Giao dịch thành công
- `07` - Trừ tiền thành công nhưng hoàn tiền không thành công
- `09` - Giao dịch không thành công
- `10` - Khách hàng hủy giao dịch
- `11` - Giao dịch không hợp lệ
- `12` - Khác

## Test với Sandbox

### Tài Khoản Test VNPay
1. Truy cập: https://sandbox.vnpayment.vn
2. Đăng nhập với tài khoản merchant của bạn
3. Sử dụng test card từ tài liệu VNPay

### Test Card (Sandbox)
- Card Number: `4111111111111111`
- Exp Date: `12/25`
- CVV: `123`
- OTP: `123456`

## Xử Lý Lỗi

### Lỗi Xác Minh Chữ Ký
```
"Chữ ký thanh toán không hợp lệ"
```
- Kiểm tra HASH_SECRET có khớp không
- Kiểm tra order có tồn tại không

### Lỗi Kết Nối VNPay
```
"Không thể kết nối đến VNPay"
```
- Kiểm tra APP_URL có đúng không
- Kiểm tra Network/Firewall settings

### Lỗi Hoàn Tiền
```
"Không thể hoàn tiền cho đơn hàng này"
```
- Chỉ hoàn tiền được nếu:
  - Thanh toán đã hoàn tất (`payment_status = 'completed'`)
  - Đơn hàng chưa giao (`status` không phải 'shipped', 'delivered', 'cancelled')

## Bảo Mật

### Best Practices
1. **HTTPS Only**: Luôn sử dụng HTTPS trên production
2. **Xác Minh Chữ Ký**: Luôn xác minh chữ ký HMAC SHA512 từ VNPay
3. **Hash Secret**: Bảo vệ VNPAY_HASH_SECRET, không commit vào git
4. **IP Whitelist**: VNPay hỗ trợ whitelist IP
5. **Timeout**: Callback có timeout, xử lý idempotent (kiểm tra transaction_id tồn tại)

## Troubleshooting

### 1. Callback không được nhận
- Kiểm tra APP_URL và APP_DEBUG settings
- Đảm bảo server có thể nhận request từ VNPay
- Kiểm tra logs: `storage/logs/laravel.log`

### 2. Lỗi Hash mismatch
- Xác nhận TMN_CODE và HASH_SECRET chính xác
- Kiểm tra environment (sandbox vs production)

### 3. IPN Signature Mismatch
```
'Chữ ký thanh toán không hợp lệ'
```
- VNPay cung cấp 2 chữ ký: `vnp_SecureHash` và `vnp_SecureHashType`
- Hãy đảm bảo xóa cả 2 trước khi tính hash

## Liên Hệ Support
- VNPay Merchant: https://merchant.vnpayment.vn
- VNPay Support: support@vnpayment.vn
- Tài Liệu API: https://sandbox.vnpayment.vn/apis/

## Lưu Ý Quan Trọng

1. **Sandbox vs Production**: 
   - Sandbox dùng để test, không lấy tiền thật
   - Production dùng với URLs khác

2. **Số Tiền**:
   - VNPay tính bằng VND
   - Gửi `amount * 100` (vì backend yêu cầu)

3. **Timezone**:
   - VNPay sử dụng GMT+7 (Việt Nam)
   - Đảm bảo server timezone chính xác

4. **Order Status Flow**:
   ```
   pending → completed (direct payment)
   pending → completed (vnpay success)
   pending → failed (vnpay fail)
   completed → refunded (hoàn tiền)
   ```

---

**Phiên bản**: 1.0  
**Ngày tạo**: 2026-01-16  
**Trạng thái**: Production Ready
