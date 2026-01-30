<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f9fafb;
            color: #334155;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #334155;
        }
        .order-details {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid #6366f1;
        }
        .order-details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .label {
            color: #64748b;
            font-weight: 500;
        }
        .value {
            color: #0f172a;
            font-weight: 600;
        }
        .order-items {
            margin: 30px 0;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .item-name {
            font-weight: 500;
            color: #334155;
        }
        .item-price {
            color: #6366f1;
            font-weight: 600;
        }
        .total {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            border-top: 2px solid #e2e8f0;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }
        .total-amount {
            color: #6366f1;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 30px;
            text-align: center;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
        }
        .footer a {
            color: #6366f1;
            text-decoration: none;
        }
        .success-badge {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i style="font-size: 32px;">✓</i></h1>
            <h2>Đơn Hàng Đã Xác Nhận</h2>
            <p style="margin-top: 8px; opacity: 0.9;">Thanh toán thành công</p>
        </div>

        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $order->user->name }}</strong>,<br>
                <br>
                Cảm ơn bạn đã đăng ký khóa học tại {{ config('app.name') }}! Đơn hàng của bạn đã được xác nhận và xử lý thành công.
            </div>

            <div class="order-details">
                <div class="order-details-row">
                    <span class="label">Mã Đơn Hàng:</span>
                    <span class="value">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="order-details-row">
                    <span class="label">Ngày Đặt Hàng:</span>
                    <span class="value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="order-details-row">
                    <span class="label">Phương Thức Thanh Toán:</span>
                    <span class="value">
                        @if($order->payment_method === 'vnpay')
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 12px;">VNPay</span>
                        @elseif($order->payment_method === 'cod')
                            <span style="background: #fed7aa; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Thanh toán khi nhận</span>
                        @else
                            {{ ucfirst($order->payment_method) }}
                        @endif
                    </span>
                </div>
                <div class="order-details-row">
                    <span class="label">Trạng Thái:</span>
                    <span class="value" style="color: #059669;">✓ Hoàn tất</span>
                </div>
            </div>

            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Khóa Học Đã Mua</h3>
            
            <div class="order-items">
                @foreach($order->items as $item)
                    <div class="order-item">
                        <span class="item-name">{{ $item->course->title }}</span>
                        <span class="item-price">{{ (int) $item->price }} VND</span>
                    </div>
                @endforeach
            </div>

            <div class="total">
                <span>Tổng Cộng:</span>
                <span class="total-amount">{{ (int) $order->total_price }} VND</span>
            </div>

            <p style="margin-top: 30px; color: #64748b; line-height: 1.6;">
                Bạn hiện có thể bắt đầu học tất cả các khóa học bạn vừa mua. Nhấp vào nút bên dưới để truy cập kho khóa học của bạn.
            </p>

            <a href="{{ url('/profile') }}" class="cta-button">Truy Cập Khóa Học Của Tôi</a>

            <div style="margin-top: 40px; padding: 20px; background: #f8fafc; border-radius: 12px; font-size: 14px; color: #64748b; line-height: 1.6;">
                <strong>Gợi ý:</strong> 
                <ul style="margin-top: 10px; padding-left: 20px;">
                    <li>Bạn sẽ có quyền truy cập trọn đời vào tất cả các khóa học.</li>
                    <li>Bạn có thể tải xuống tài liệu và học offline.</li>
                    <li>Đừng quên hoàn thành các bài kiểm tra để nhận chứng chỉ!</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>Nếu có bất kỳ câu hỏi nào, vui lòng <a href="mailto:support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}">liên hệ hỗ trợ</a>.</p>
            <p style="margin-top: 15px;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
