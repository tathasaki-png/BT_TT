<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 5px 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Chào mừng bạn!</h1>
        </div>
        <div class="content">
            <p>Xin chào <strong>{{ $userName }}</strong>,</p>
            
            <p>Cảm ơn bạn đã đăng ký tài khoản tại ứng dụng của chúng tôi. Chúng tôi rất vui khi có bạn trở thành một phần của cộng đồng của chúng tôi.</p>
            
            <p>Email này được gửi qua hệ thống queue của Laravel, cho phép gửi email hàng loạt mà không bị timeout.</p>
            
            <p><strong>Các tính năng chính:</strong></p>
            <ul>
                <li>✓ Gửi email asynchronous thông qua queue</li>
                <li>✓ Tự động retry nếu gửi thất bại</li>
                <li>✓ Ghi log toàn bộ quá trình gửi</li>
                <li>✓ Hỗ trợ database và Redis driver</li>
            </ul>
            
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
            
            <p>Trân trọng,<br>
            <strong>Đội ngũ ứng dụng</strong></p>
        </div>
        <div class="footer">
            <p>&copy; 2026 Ứng dụng của chúng tôi. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
