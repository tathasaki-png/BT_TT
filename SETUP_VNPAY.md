# Cấu Hình VNPay - Hướng Dẫn Chi Tiết

## 📋 Danh Sách Các Bước

### 1. Cấu Hình Environment

Thêm các dòng dưới đây vào file `.env` của bạn:

```env
# VNPay Payment Gateway Configuration
VNPAY_TMN_CODE=TMNCODE
VNPAY_HASH_SECRET=HASHSECRET
VNPAY_PAYMENT_URL=https://sandbox.vnpayment.vn/paygate
VNPAY_QUERY_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction
VNPAY_REFUND_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction/refund
```

### 2. Lấy TMN Code và Hash Secret

#### Bước 2.1: Đăng Ký VNPay Merchant
- Truy cập: https://sandbox.vnpayment.vn (sandbox test)
- Nhấp vào "Đăng ký tài khoản"
- Điền thông tin merchant của bạn
- Xác nhận email

#### Bước 2.2: Lấy Credentials
- Đăng nhập vào tài khoản merchant
- Vào mục: Settings → Merchant Info
- Copy `TMN Code` và `Hash Secret`
- Dán vào file `.env`

### 3. Chạy Migration

```bash
php artisan migrate
```

Lệnh này sẽ thêm các cột sau vào bảng `orders`:
- `payment_method` - Phương thức thanh toán (direct, vnpay)
- `payment_status` - Trạng thái thanh toán (pending, completed, failed, refunded)
- `transaction_id` - ID giao dịch từ VNPay
- `transaction_date` - Thời gian giao dịch

### 4. Xác Minh Cấu Hình

Tạo file `routes/test.php` để test:

```php
Route::get('/test-vnpay', function() {
    $config = config('vnpay');
    echo '<pre>';
    print_r($config);
    echo '</pre>';
});
```

Truy cập: `http://localhost/test-vnpay`

Kết quả sẽ hiển thị:
```
Array
(
    [tmn_code] => TMNCODE
    [hash_secret] => HASHSECRET
    [payment_url] => https://sandbox.vnpayment.vn/paygate
    ...
)
```

## 🔐 Bảo Mật - Lưu Ý Quan Trọng

### ⚠️ KHÔNG ĐỂ LỘ THÔNG TIN

1. **HASH_SECRET**: 
   - Là khóa bảo mật quan trọng
   - KHÔNG commit vào Git
   - Lưu riêng trong file `.env`

2. **Bảo Vệ File .env**:
   ```
   # .gitignore
   .env          # ← Đảm bảo đã bao gồm
   .env.local
   .env.*.local
   ```

3. **HTTPS**:
   - Luôn sử dụng HTTPS trên production
   - VNPay yêu cầu HTTPS để gửi callback

## 🧪 Test Với Sandbox

### Test Card (Sandbox)
- **Card Number**: 4111111111111111
- **Exp Date**: 12/25
- **CVV**: 123
- **OTP**: 123456 (hoặc bất kỳ)

### Test Flow
1. Truy cập `/checkout`
2. Chọn "Thanh toán qua VNPay"
3. Điền thông tin đơn hàng
4. Nhấp "Đặt hàng ngay"
5. Sẽ redirect sang trang VNPay
6. Nhập test card ở trên
7. Nhập OTP: 123456
8. Xác nhận thanh toán

## 🚀 Chuyển Sang Production

### Bước 1: Lấy Live Credentials

```bash
# Liên hệ VNPay để active tài khoản production
# Sẽ nhận được:
# - Live TMN Code
# - Live Hash Secret
```

### Bước 2: Cập Nhật .env

```env
# Production URLs
VNPAY_PAYMENT_URL=https://payment.vnpayment.vn/paygate
VNPAY_QUERY_URL=https://api.vnpayment.vn/merchant_webapi/api/transaction
VNPAY_REFUND_URL=https://api.vnpayment.vn/merchant_webapi/api/transaction/refund

# Production Credentials
VNPAY_TMN_CODE=your_live_tmncode
VNPAY_HASH_SECRET=your_live_hash_secret
```

### Bước 3: Kiểm Tra HTTPS

```php
// app/Http/Controllers/PaymentController.php
// Xác nhận route payment.return sử dụng HTTPS
Route::get('/payment/return', ...)->middleware('https');
```

### Bước 4: Test Real Cards

- Sử dụng thẻ thật (sẽ không lấy tiền nếu error)
- Hoặc liên hệ VNPay để active test mode cho production

## 📁 Cấu Trúc Thư Mục

```
project/
├── app/
│   ├── Services/
│   │   └── VNPayService.php          # Service xử lý VNPay
│   ├── Http/Controllers/
│   │   └── PaymentController.php     # Controller thanh toán
│   ├── Helpers/
│   │   └── PaymentHelper.php         # Helper function
│   └── Events/
│       ├── PaymentCompleted.php      # Event thanh toán thành công
│       └── PaymentFailed.php         # Event thanh toán thất bại
├── config/
│   └── vnpay.php                     # Config VNPay
├── database/
│   └── migrations/
│       └── 2026_01_16_000000_add_payment_fields_to_orders_table.php
└── resources/
    └── views/
        ├── orders/
        │   ├── checkout.blade.php    # Form thanh toán
        │   └── show.blade.php        # Chi tiết đơn hàng
        └── payment/
            ├── success.blade.php     # Trang thành công
            └── failed.blade.php      # Trang thất bại
```

## 🧠 Luồng Dữ Liệu

```
[Customer] → [Checkout Page] 
    ↓
    → [PaymentController::createPayment()] 
    ↓
    → [VNPayService::createPaymentUrl()]
    ↓
    → [Redirect to VNPay]
    ↓
[Customer inputs card] → [VNPay processes]
    ↓
    → [VNPay callback to /payment/return]
    ↓
    → [PaymentController::handleReturn()]
    ↓
    → [VNPayService::verifyPaymentResponse()]
    ↓
    [Valid] → [Update Order Status] → [Send Email]
    [Invalid] → [Redirect to /payment/failed]
    ↓
[Show Success/Failed Page]
```

## 🔍 Troubleshooting

### 1. "Chữ ký thanh toán không hợp lệ"

**Nguyên nhân**: 
- HASH_SECRET sai
- Environment (sandbox vs production) sai
- Dữ liệu bị thay đổi

**Giải pháp**:
```php
// Kiểm tra HASH_SECRET
dd(config('vnpay.hash_secret'));

// Kiểm tra URL
dd(config('vnpay.payment_url'));
```

### 2. "Không tìm thấy đơn hàng"

**Nguyên nhân**: Order không tồn tại với transaction_id

**Giải pháp**:
```php
// Kiểm tra database
Order::where('transaction_id', 'ORD...')->first();
```

### 3. Callback không được nhận

**Nguyên nhân**:
- APP_URL sai
- Server không có public internet access
- Firewall block VNPay IP

**Giải pháp**:
```env
# Đảm bảo APP_URL đúng
APP_URL=https://yourdomain.com

# Kiểm tra route
Route::get('/payment/return', ...);
```

### 4. IPN Signature Mismatch

**Nguyên nhân**: Xử lý sai chữ ký HMAC SHA512

**Giải pháp**:
```php
// Kiểm tra VNPayService::verifyPaymentResponse()
// Đảm bảo xóa vnp_SecureHash trước khi tính hash
unset($data['vnp_SecureHash']);
```

## 📞 Liên Hệ Hỗ Trợ

- **VNPay Sandbox**: https://sandbox.vnpayment.vn
- **VNPay Live**: https://merchant.vnpayment.vn
- **VNPay Documentation**: https://sandbox.vnpayment.vn/apis/
- **VNPay Support Email**: support@vnpayment.vn
- **VNPay Hotline**: 1900 6486

## 📝 Tài Liệu Tham Khảo

- [VNPay Payment Gateway API Documentation](https://sandbox.vnpayment.vn/apis/)
- [HMAC-SHA512 Algorithm](https://en.wikipedia.org/wiki/HMAC)
- [Laravel HTTP Client](https://laravel.com/docs/http-client)
- [Laravel Events](https://laravel.com/docs/events)

---

**Cập nhật lần cuối**: 2026-01-16  
**Phiên bản**: 1.0
