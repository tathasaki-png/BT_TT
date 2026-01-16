<!DOCTYPE html>
<html>
<head>
    <title>VNPay Test Return</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .success { color: #28a745; background: #d4edda; padding: 15px; border-radius: 5px; }
        .error { color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 5px; }
        .info { color: #0c5460; background: #d1ecf1; padding: 15px; border-radius: 5px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>VNPay Return URL Test</h1>
        
        <div class="info">
            <h3>✅ Route hoạt động tốt!</h3>
            <p>URL: {{ request()->fullUrl() }}</p>
        </div>

        <h3>Parameters từ VNPay:</h3>
        <pre>{{ json_encode(request()->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

        <h3>Verification Result:</h3>
        @php
            try {
                $vnpayService = app(\App\Services\VNPayService::class);
                $verification = $vnpayService->verifyPaymentResponse(request()->all());
                echo '<pre>' . json_encode($verification, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';
            } catch (\Exception $e) {
                echo '<div class="error">Error: ' . $e->getMessage() . '</div>';
            }
        @endphp

        <p><a href="{{ route('home') }}">← Quay về trang chủ</a></p>
    </div>
</body>
</html>