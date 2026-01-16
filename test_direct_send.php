<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

echo "=== TEST GỬI EMAIL TRỰC TIẾP (KHÔNG QUEUE) ===\n\n";

$email = 'vql2111@gmail.com';
$name = 'Test Direct Send - ' . date('H:i:s');

echo "Sending to: $email\n";
echo "From: " . config('mail.from.address') . "\n";
echo "Driver: " . config('mail.mailer') . "\n\n";

try {
    echo "🔄 Attempting to send email...\n";
    
    $result = Mail::to($email)->send(new WelcomeEmail($name));
    
    echo "✅ Mail::to()->send() returned: " . var_export($result, true) . "\n";
    echo "✅ Email gửi thành công!\n";
    
} catch (\Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
