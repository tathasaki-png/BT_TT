<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;

echo "=== TEST ĐĂNG KÝ USER MỚI ===\n\n";

$user = User::create([
    'name' => 'Nguyễn Văn A - ' . date('H:i:s'),
    'email' => 'test' . time() . '@gmail.com',
    'password' => bcrypt('password123'),
]);

echo "✓ User created: {$user->name}\n";
echo "  Email: {$user->email}\n";
echo "  ID: {$user->id}\n\n";

echo "📤 Dispatching email job...\n";
SendWelcomeEmailJob::dispatch($user->email, $user->name);

echo "⏳ Waiting for queue to process (5 seconds)...\n";
sleep(5);

echo "\n✅ Done! Check laravel.log để xem email được generate.\n";

// Check job log
$log = \DB::table('job_logs')->where('email', $user->email)->latest()->first();
if ($log) {
    echo "\n📋 Job Log:\n";
    echo "  Status: {$log->status}\n";
    echo "  Created: {$log->created_at}\n";
}
