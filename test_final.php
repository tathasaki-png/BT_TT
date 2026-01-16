<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;

echo "=== TEST GỬI EMAIL TỚI vql2111@gmail.com ===\n\n";

$realEmail = 'vql2111@gmail.com';

// Kiểm tra user đã tồn tại chưa
$user = User::where('email', $realEmail)->first();

if (!$user) {
    $user = User::create([
        'name' => 'Người Dùng Thực - ' . date('H:i:s'),
        'email' => $realEmail,
        'password' => bcrypt('password123'),
    ]);
    echo "✓ User mới created\n";
} else {
    echo "✓ User tồn tại: {$user->name}\n";
}

echo "  Email: {$user->email}\n\n";

echo "📤 Dispatching welcome email job...\n";
SendWelcomeEmailJob::dispatch($user->email, $user->name);

echo "⏳ Waiting for queue to process (5 seconds)...\n";
sleep(5);

$log = \DB::table('job_logs')
    ->where('email', $realEmail)
    ->latest()
    ->first();

echo "\n✅ Job Status: {$log->status}\n";

if ($log->error_message) {
    echo "❌ Error: " . $log->error_message . "\n";
} else {
    echo "✅ Email gửi thành công!\n";
    echo "\n📧 Kiểm tra inbox của {$realEmail}\n";
    echo "   Subject: Chào mừng đến với ứng dụng của chúng tôi!\n";
}
