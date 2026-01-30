<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f9fafb; color: #334155; }
        .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .header { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 40px 30px; text-align: center; }
        .header h1 { font-size: 28px; margin-bottom: 10px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 16px; margin-bottom: 20px; color: #334155; }
        .message-box { background: #f0fdf4; border-left: 4px solid #16a34a; padding: 20px; border-radius: 8px; margin-bottom: 30px; color: #166534; font-weight: 500; font-size: 15px; }
        .order-details { background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 30px; border: 1px solid #e2e8f0; }
        .order-details-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .label { color: #64748b; font-weight: 500; }
        .value { color: #0f172a; font-weight: 600; }
        .order-items { margin: 30px 0; }
        .order-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .total { display: flex; justify-content: space-between; padding: 20px 0; border-top: 2px solid #e2e8f0; font-size: 18px; font-weight: 700; color: #0f172a; }
        .total-amount { color: #16a34a; }
        .footer { background: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b; }
        .footer a { color: #16a34a; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i style="font-size: 32px;">🕒</i></h1>
            <h2>Đơn Hàng Chờ Xác Nhận</h2>
            <p style="margin-top: 8px; opacity: 0.9;">Phương thức: Thanh toán khi nhận hàng (COD)</p>
        </div>

        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $userName }}</strong>,
            </div>

            <div class="message-box">
                Cảm ơn bạn đã tin tưởng ủng hộ, shop sẽ chuẩn bị hàng và chuyển đi sớm nhất có thể.
            </div>

            <p style="margin-bottom: 20px; line-height: 1.6;">
                Chúng tôi đã nhận được yêu cầu đặt hàng của bạn. Đơn hàng sẽ được xử lý ngay sau khi nhân viên của chúng tôi xác nhận thông tin.
            </p>

            <div class="order-details">
                <div class="order-details-row">
                    <span class="label">Mã Đơn Hàng:</span>
                    <span class="value">#{{ $orderNumber }}</span>
                </div>
                <div class="order-details-row">
                    <span class="label">Ngày Đặt Hàng:</span>
                    <span class="value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="order-details-row">
                    <span class="label">Trạng Thái:</span>
                    <span class="value" style="color: #64748b;">⏳ Chờ xác nhận</span>
                </div>
            </div>

            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Chi Tiết Khóa Học</h3>
            <div class="order-items">
                @foreach($order->items as $item)
                    <div class="order-item">
                        <span class="item-name">{{ $item->course->title }}</span>
                        <span class="item-price">{{ (int) $item->price }} VND</span>
                    </div>
                @endforeach
            </div>

            <div class="total">
                <span>Tổng Thanh Toán:</span>
                <span class="total-amount">{{ (int) $order->total_price }} VND</span>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p style="margin-top: 10px;">Nếu bạn có thắc mắc, hãy <a href="{{ url('/') }}">liên hệ với chúng tôi</a>.</p>
        </div>
    </div>
</body>
</html>
