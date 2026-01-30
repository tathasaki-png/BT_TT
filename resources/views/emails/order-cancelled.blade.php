<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>body{font-family:Arial,Helvetica,sans-serif;color:#111}</style>
  <title>Đơn hàng bị hủy</title>
</head>
<body>
  <div style="max-width:600px;margin:20px auto;padding:20px;border:1px solid #eee;border-radius:8px;background:#fff;">
    <h2 style="color:#e11">Đơn hàng #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }} đã bị hủy</h2>
    <p>Xin chào <strong>{{ $order->user->name }}</strong>,</p>
    <p>Chúng tôi xin thông báo rằng đơn hàng của bạn chứa một hoặc nhiều khóa học đã bị hủy bởi quản trị viên và đơn hàng đã được đặt sang trạng thái <strong>Đã hủy</strong>.</p>
    <h4>Chi tiết đơn hàng</h4>
    <ul>
      @foreach($order->items as $item)
        <li>{{ $item->course->title }} — {{ (int) $item->price }} VND</li>
      @endforeach
    </ul>
    <p>Tổng: <strong>{{ (int) $order->total_price }} VND</strong></p>
    <p>Nếu bạn cần hỗ trợ thêm, vui lòng trả lời email này hoặc liên hệ bộ phận hỗ trợ.</p>
    <p>Trân trọng,<br>{{ config('app.name') }}</p>
  </div>
</body>
</html>
