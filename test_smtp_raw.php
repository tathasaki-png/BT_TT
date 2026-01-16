<?php
require 'vendor/autoload.php';
use Illuminate\Support\Facades\Mail;

$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Sending Test Email via SMTP ===\n";
echo "Email config: " . config('mail.mailer') . "\n\n";

try {
    // Gửi email raw
    Mail::raw('Email Test - Được gửi lúc ' . date('Y-m-d H:i:s'), function ($message) {
        $message->to('tat.hasaki@gmail.com')
                ->subject('Test - ' . date('Y-m-d H:i:s'));
    });
    
    echo "✅ Email sent successfully!\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
