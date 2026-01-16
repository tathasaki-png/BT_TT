<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\JobLog;
use App\Jobs\SendWelcomeEmailJob;

echo "=== TEST ĐĂNG KÝ GIỐNG WEB FORM ===\n\n";

$timestamp = date('H:i:s');
$email = 'testuser' . time() . '@gmail.com';
$name = "Test User - $timestamp";

// 1. Create user
echo "1️⃣ Tạo user...\n";
$user = User::create([
    'name' => $name,
    'email' => $email,
    'password' => bcrypt('password123'),
]);
echo "   ✓ User created: ID={$user->id}, Email={$user->email}\n\n";

// 2. Create JobLog (pending)
echo "2️⃣ Tạo JobLog entry...\n";
$jobLog = JobLog::create([
    'job_name' => SendWelcomeEmailJob::class,
    'email' => $user->email,
    'status' => 'pending',
    'payload' => json_encode([
        'userName' => $user->name,
        'email' => $user->email,
    ]),
    'max_retries' => 3,
]);
echo "   ✓ JobLog created: ID={$jobLog->id}, Status=pending\n\n";

// 3. Dispatch job
echo "3️⃣ Dispatch SendWelcomeEmailJob...\n";
SendWelcomeEmailJob::dispatch($user->email, $user->name);
echo "   ✓ Job dispatched\n\n";

// 4. Check database
echo "4️⃣ Kiểm tra database...\n";
$jobCount = \DB::table('jobs')->count();
$jobLogEntry = JobLog::where('email', $email)->latest()->first();
echo "   📊 Jobs table count: $jobCount\n";
echo "   📝 JobLog entry: ID={$jobLogEntry->id}, Status={$jobLogEntry->status}\n\n";

// 5. Wait for queue processing
echo "5️⃣ Chờ queue xử lý (10 giây)...\n";
for ($i = 0; $i < 10; $i++) {
    echo "   ⏱️  " . (10 - $i) . " giây còn lại...\n";
    sleep(1);
}

// 6. Check result
echo "\n6️⃣ Kết quả sau khi queue:listen xử lý:\n";
$jobLogFinal = JobLog::where('email', $email)->latest()->first();
echo "   📝 Status: {$jobLogFinal->status}\n";
if ($jobLogFinal->status === 'failed') {
    echo "   ❌ Error: {$jobLogFinal->error_message}\n";
}

// 7. Check jobs table
$jobInQueue = \DB::table('jobs')->where('payload', 'LIKE', "%{$email}%")->first();
echo "\n7️⃣ Còn job trong queue không?\n";
if ($jobInQueue) {
    echo "   ⚠️  Còn job: attempt={$jobInQueue->attempts}\n";
} else {
    echo "   ✓ Không còn job (đã xử lý)\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "📧 Email được gửi đến: $email\n";
echo "🔍 Vui lòng kiểm tra inbox/spam\n";
echo "=" . str_repeat("=", 50) . "\n";
