<?php

// Test file to send email to tat.hasaki@gmail.com
// Usage: php test-mail-send.php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Order;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\Mail;

echo "🧪 Test Sending Email to tat.hasaki@gmail.com\n";
echo "============================================\n\n";

// Get first order
$order = Order::with('user')->first();

if (!$order) {
    echo "❌ No order found in database\n";
    exit(1);
}

echo "✅ Order found:\n";
echo "   Order ID: {$order->id}\n";
echo "   User: {$order->user->name}\n";
echo "   Current User Email: {$order->user->email}\n";
echo "\n";

// Send email to user's registered email
$userEmail = $order->user->email;
echo "📧 Sending email to user: $userEmail\n";

try {
    Mail::to($userEmail)->send(new OrderCompletedMail($order));
    echo "✅ Email sent successfully!\n";
    echo "\n";
    echo "📝 Check logs: tail -f storage/logs/laravel.log\n";
    echo "📧 Email sent FROM: tat.hasaki@gmail.com\n";
    echo "📧 Email sent TO: $userEmail\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
