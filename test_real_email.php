<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;

echo "=== TEST ĐĂNG KÝ USER VỚI EMAIL THỰC ===\n\n";

// Dùng email thực
$realEmail = 'vql2111@gmail.com';

$user = User::create([
    'name' => 'Người Dùng Thực - ' . date('H:i:s'),
    'email' => $realEmail,
    'password' => bcrypt('password123'),
]);

echo "✓ User created: {$user->name}\n";
echo "  Email: {$user->email}\n";
echo "  ID: {$user->id}\n\n";

echo "📤 Dispatching email job...\n";
SendWelcomeEmailJob::dispatch($user->email, $user->name);

echo "⏳ Waiting for queue to process (5 seconds)...\n";
sleep(5);

echo "\n✅ Done! Check Gmail inbox của $realEmail\n";

// Check job log
$log = \DB::table('job_logs')->where('email', $user->email)->latest()->first();
if ($log) {
    echo "\n📋 Job Log:\n";
    echo "  Status: {$log->status}\n";
    echo "  Error: " . ($log->error_message ? substr($log->error_message, 0, 100) : "None") . "\n";
}
