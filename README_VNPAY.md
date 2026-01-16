# VNPay Payment Gateway Integration - Hướng Dẫn Hoàn Chỉnh

## 📚 Mục Lục
1. [Giới Thiệu](#giới-thiệu)
2. [Cài Đặt Nhanh](#cài-đặt-nhanh)
3. [Cấu Hình Chi Tiết](#cấu-hình-chi-tiết)
4. [Sử Dụng API](#sử-dụng-api)
5. [Kiểm Tra & Debug](#kiểm-tra--debug)
6. [Production Deploy](#production-deploy)
7. [Troubleshooting](#troubleshooting)

## 🎯 Giới Thiệu

Tích hợp VNPay payment gateway vào hệ thống shop online của bạn, cho phép khách hàng:
- ✅ Thanh toán qua thẻ ngân hàng
- ✅ Thanh toán qua ví điện tử (Momo, ZaloPay, etc.)
- ✅ Thanh toán ATM
- ✅ Hoàn tiền (Refund) khi cần

### Tính Năng Chính
- 🔐 Xác minh chữ ký HMAC SHA512
- 📱 Responsive thanh toán UI
- 🔄 Hỗ trợ hoàn tiền
- 📧 Gửi email xác nhận
- 🧪 Debug tools cho development
- 🚀 Production ready

## 🚀 Cài Đặt Nhanh

### 1️⃣ Cấu Hình .env

Thêm vào file `.env` của bạn:

```env
VNPAY_TMN_CODE=TMNCODE
VNPAY_HASH_SECRET=HASHSECRET
VNPAY_PAYMENT_URL=https://sandbox.vnpayment.vn/paygate
VNPAY_QUERY_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction
VNPAY_REFUND_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction/refund
```

### 2️⃣ Chạy Migration

```bash
php artisan migrate
```

Điều này sẽ tạo các cột mới trong bảng `orders`:
- `payment_method` VARCHAR(50)
- `payment_status` VARCHAR(50)
- `transaction_id` VARCHAR(255)
- `transaction_date` DATETIME

### 3️⃣ Clear Cache

```bash
php artisan config:cache
```

✅ Hoàn tất! Bây giờ bạn có thể bắt đầu sử dụng.

---

## 🔧 Cấu Hình Chi Tiết

### Bước 1: Đăng Ký VNPay

#### Sandbox (Test)
1. Truy cập: https://sandbox.vnpayment.vn
2. Click "Đăng ký tài khoản"
3. Điền thông tin:
   - Email merchant
   - Mật khẩu
   - Tên công ty (có thể fake)
4. Xác nhận email
5. Đăng nhập

#### Production (Live)
1. Liên hệ VNPay: support@vnpayment.vn
2. Cung cấp:
   - Giấy phép kinh doanh
   - Hợp đồng dịch vụ
   - Website
3. Đợi phê duyệt (3-5 ngày)
4. Nhận TMN Code & Hash Secret

### Bước 2: Lấy Credentials

Đăng nhập vào merchant dashboard:
1. Vào **Settings** → **Merchant Info**
2. Copy **TMN Code**
3. Copy **Hash Secret Key**
4. Dán vào `.env`:

```env
VNPAY_TMN_CODE=1700000000         # TMN Code
VNPAY_HASH_SECRET=ABCDEF123456    # Hash Secret
```

### Bước 3: Cấu Hình Return URL

VNPay cần biết trang nào để callback sau khi thanh toán:

```env
APP_URL=http://localhost  # Sandbox
APP_URL=https://yourdomain.com  # Production
```

Route callback mặc định:
```
{APP_URL}/payment/return
```

VNPay sẽ gửi request GET đến URL này với các tham số.

### Bước 4: Whitelist IP (Production)

Trên dashboard VNPay, whitelist IP server của bạn:

```
Merchant Dashboard → Settings → IPN Configuration
Thêm IP của server production
```

---

## 🎮 Sử Dụng API

### 1. Tạo Thanh Toán

**Khách hàng truy cập:**
```
GET /checkout
```

**Chọn phương thức:**
- ☑️ Thanh toán khi nhận hàng
- ☑️ Thanh toán qua VNPay

**Submit form:**
```
POST /order/place
```

**Request body:**
```json
{
  "name": "Nguyễn Văn A",
  "email": "nguyenvana@gmail.com",
  "phone": "0912345678",
  "address": "123 Đường ABC, Quận 1, TP.HCM",
  "payment_method": "vnpay"  // or "direct"
}
```

**Response:**
- Nếu `direct`: Redirect đến `/orders/history`
- Nếu `vnpay`: Redirect đến VNPay gateway

### 2. Xử Lý Callback (Automatic)

VNPay sẽ gửi callback đến:
```
GET /payment/return?vnp_TxnRef=...&vnp_ResponseCode=00&...
```

Hệ thống sẽ:
1. ✅ Xác minh chữ ký
2. ✅ Cập nhật order status
3. ✅ Gửi email
4. ✅ Redirect đến success/failed page

### 3. Kiểm Tra Trạng Thái (AJAX)

**Request:**
```bash
curl -X POST http://localhost/payment/check-status \
  -H "Content-Type: application/json" \
  -d '{"order_id": 1}'
```

**Response:**
```json
{
  "TransactionNo": "14009348",
  "TransactionDate": "20260116123456",
  "TransactionType": "payment",
  "Status": "Success"
}
```

### 4. Yêu Cầu Hoàn Tiền (AJAX)

**Request:**
```bash
curl -X POST http://localhost/payment/refund \
  -H "Content-Type: application/json" \
  -d '{"order_id": 1}'
```

**Response:**
```json
{
  "success": true,
  "message": "Yêu cầu hoàn tiền đã được gửi",
  "result": {
    "TransactionStatus": "Refunded",
    "RefundAmount": 1000000
  }
}
```

---

## 🧪 Kiểm Tra & Debug

### Debug Endpoints (Local Only)

```bash
# 1. Xem cấu hình
GET http://localhost/debug/vnpay/config

# Response:
# {
#   "vnpay_config": {
#     "tmn_code": "TMNCODE",
#     "payment_url": "https://sandbox.vnpayment.vn/paygate",
#     ...
#   }
# }

# 2. Test tạo URL thanh toán
GET http://localhost/debug/vnpay/test-create-url

# 3. Test xác minh response
GET http://localhost/debug/vnpay/test-verify

# 4. Test tạo mã giao dịch
GET http://localhost/debug/vnpay/test-txn-ref

# 5. Test kết nối VNPay
GET http://localhost/debug/vnpay/test-connection
```

### Sandbox Test Cards

| Card Number | Exp Date | CVV | OTP | Kết quả |
|---|---|---|---|---|
| 4111111111111111 | 12/25 | 123 | 123456 | ✅ Thành công |
| 4012001036010001 | 12/25 | 123 | 123456 | ✅ Thành công |
| 4111111111111112 | 12/25 | 123 | 123456 | ❌ Thất bại |

### Log Files

Kiểm tra logs tại:
```
storage/logs/laravel.log
```

Tìm kiếm:
```
payment
vnpay
transaction
```

### Database Queries

Kiểm tra giao dịch:
```php
// Tất cả giao dịch VNPay
Order::where('payment_method', 'vnpay')->get();

// Giao dịch thành công
Order::where('payment_status', 'completed')->get();

// Giao dịch thất bại
Order::where('payment_status', 'failed')->get();

// Giao dịch bị hoàn
Order::where('payment_status', 'refunded')->get();

// Kiểm tra một giao dịch
Order::where('transaction_id', 'ORD20260116...')->first();
```

---

## 🚀 Production Deploy

### Checklist Pre-Deployment

```bash
# 1. Cập nhật .env.production
VNPAY_TMN_CODE=your_live_tmncode
VNPAY_HASH_SECRET=your_live_hash_secret
VNPAY_PAYMENT_URL=https://payment.vnpayment.vn/paygate
VNPAY_QUERY_URL=https://api.vnpayment.vn/merchant_webapi/api/transaction
VNPAY_REFUND_URL=https://api.vnpayment.vn/merchant_webapi/api/transaction/refund

# 2. Bật HTTPS
# - Cấu hình SSL certificate
# - Update APP_URL=https://yourdomain.com

# 3. Migrate database
php artisan migrate --force

# 4. Clear cache
php artisan config:cache
php artisan route:cache

# 5. Disable debug
APP_DEBUG=false

# 6. Setup monitoring
# - NewRelic, Sentry, DataDog, etc.

# 7. Backup database
# - Cấu hình automated backups

# 8. Whitelist IP
# - Whitelist VNPay IPs trên server firewall
```

### VNPay Whitelist IPs

Thêm vào firewall:
```
180.93.255.224/28
180.93.255.240/28
```

### Email Configuration

Cấu hình email trong `.env`:
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Your Store"
```

### Monitoring & Alerts

Setup alerts cho:
- ❌ Payment failures
- ⚠️ High refund rate
- 🔴 Payment gateway down
- 📉 Transaction value anomalies

---

## ❓ Troubleshooting

### Error 1: "Chữ ký thanh toán không hợp lệ"

**Nguyên nhân:**
- HASH_SECRET sai
- Environment (sandbox vs production) không khớp
- Dữ liệu bị thay đổi

**Giải pháp:**
```php
// File: config/vnpay.php
dd([
    'tmn_code' => config('vnpay.tmn_code'),
    'hash_secret_first_20_chars' => substr(config('vnpay.hash_secret'), 0, 20),
    'payment_url' => config('vnpay.payment_url'),
]);
```

Kiểm tra:
- TMN Code có khớp?
- Hash Secret đúng?
- URL đúng sandbox hay production?

### Error 2: "Không tìm thấy đơn hàng"

**Nguyên nhân:**
- Order không tồn tại
- Transaction ID không lưu

**Giải pháp:**
```php
// Kiểm tra database
Order::where('transaction_id', 'ORD20260116...')->first();

// Kiểm tra logs
tail -f storage/logs/laravel.log | grep -i "payment"
```

### Error 3: "Callback không được nhận"

**Nguyên nhân:**
- APP_URL sai
- Server không public
- Firewall block

**Giải pháp:**
```env
# Đảm bảo APP_URL đúng
APP_URL=https://yourdomain.com

# Test endpoint
curl https://yourdomain.com/payment/return?vnp_TxnRef=test&vnp_ResponseCode=00

# Check server logs
tail -f /var/log/apache2/access.log | grep payment
```

### Error 4: "HMAC verification failed"

**Nguyên nhân:**
- Xử lý sai chữ ký
- Không xóa `vnp_SecureHash` trước khi tính hash

**Giải pháp:**
```php
// VNPayService::verifyPaymentResponse()
// Phải xóa trước
unset($data['vnp_SecureHash']);
unset($data['vnp_SecureHashType']);

// Sau đó tính hash lại
$calculatedHash = hash_hmac('sha512', $hashData, $this->hashSecret);
```

---

## 📚 Tài Liệu Tham Khảo

### VNPay API Docs
- Sandbox: https://sandbox.vnpayment.vn/apis/
- Production: https://merchant.vnpayment.vn

### Tham khảo:
- [HMAC-SHA512](https://en.wikipedia.org/wiki/HMAC)
- [Laravel HTTP Client](https://laravel.com/docs/http-client)
- [Laravel Events](https://laravel.com/docs/events)
- [URL Encoding](https://en.wikipedia.org/wiki/Percent-encoding)

---

## 📞 Liên Hệ Support

### VNPay Support
- Email: support@vnpayment.vn
- Hotline: 1900 6486
- Website: https://vnpayment.vn

### Developer Support
- Telegram: [VNPay Developer Group]
- GitHub: [VNPay/VNPay-PHP-SDK](https://github.com/VNPAYCOM/php)

---

## 🎓 Best Practices

### Security
✅ Luôn verify HMAC signature  
✅ Luôn sử dụng HTTPS  
✅ Không hardcode credentials  
✅ Rotate API keys định kỳ  
✅ Log tất cả transactions  

### Performance
✅ Cache payment status  
✅ Async send emails  
✅ Limit refund requests  
✅ Monitor response time  

### UX
✅ Clear success/failed pages  
✅ Allow retry payments  
✅ Show transaction reference  
✅ Send email confirmations  
✅ Responsive design  

---

## 📊 File Structure

```
app/
├── Services/
│   └── VNPayService.php              # 270 lines
├── Http/Controllers/
│   ├── PaymentController.php         # 200 lines
│   ├── OrderController.php           # Modified
│   └── VNPayDebugController.php      # 120 lines
├── Helpers/
│   └── PaymentHelper.php             # 80 lines
├── Events/
│   ├── PaymentCompleted.php
│   └── PaymentFailed.php
└── Models/
    └── Order.php                     # Modified

config/
└── vnpay.php                         # 20 lines

database/
└── migrations/
    └── 2026_01_16_000000_add_payment_fields_to_orders_table.php

resources/
└── views/
    ├── orders/
    │   ├── checkout.blade.php        # Modified
    │   └── show.blade.php            # Modified
    └── payment/
        ├── success.blade.php         # 50 lines
        └── failed.blade.php          # 50 lines

routes/
└── web.php                           # Modified

docs/
├── VNPAY_INTEGRATION_GUIDE.md        # 250+ lines
├── SETUP_VNPAY.md                    # 200+ lines
└── IMPLEMENTATION_SUMMARY.md         # 150+ lines
```

---

## 🎉 Kết Thúc

Bạn đã hoàn tất tích hợp VNPay! 

**Next Steps:**
1. ✅ Test payment flow
2. ✅ Setup monitoring
3. ✅ Configure emails
4. ✅ Deploy to production

**Happy Coding!** 🚀

---

**Version**: 1.0  
**Last Updated**: 2026-01-16  
**Status**: Production Ready ✅
