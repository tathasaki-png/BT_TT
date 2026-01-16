<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;

echo "=== TEST SEND EMAIL ===\n\n";

// Tạo email mới cho mỗi test
$testEmail = 'testuser' . time() . '@gmail.com';

$user = User::create([
    'name' => 'Test User ' . date('H:i:s'),
    'email' => $testEmail,
    'password' => bcrypt('password123'),
]);

echo "✓ User created: {$user->name}\n";
echo "  Email: {$user->email}\n\n";

echo "📤 Dispatching job...\n";
SendWelcomeEmailJob::dispatch($user->email, $user->name);

echo "⏳ Waiting 5 seconds...\n";
sleep(5);

$log = \DB::table('job_logs')->where('email', $testEmail)->latest()->first();

echo "\n✅ Job Status: {$log->status}\n";
if ($log->error_message) {
    echo "❌ Error: " . substr($log->error_message, 0, 200) . "\n";
} else {
    echo "✅ Email gửi thành công!\n";
    echo "📧 Check Gmail inbox của {$user->email}\n";
}
