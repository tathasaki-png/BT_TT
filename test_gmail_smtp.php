<?php
// Test gửi email qua Gmail SMTP

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Mail;

try {
    echo "=== Test Gmail SMTP Email Sending ===\n\n";
    
    // Test mail config
    echo "📧 Mail Configuration:\n";
    echo "  Mailer: " . config('mail.default') . "\n";
    echo "  Host: " . config('mail.mailers.smtp.host') . "\n";
    echo "  Port: " . config('mail.mailers.smtp.port') . "\n";
    echo "  From: " . config('mail.from.address') . "\n\n";
    
    // Tạo user mới
    $user = User::create([
        'name' => 'Gmail Test User - ' . date('H:i:s'),
        'email' => 'test' . time() . '@example.com',
        'password' => bcrypt('password123'),
    ]);
    
    echo "✓ User created: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  ID: {$user->id}\n\n";
    
    // Dispatch job
    SendWelcomeEmailJob::dispatch($user->email, $user->name);
    
    echo "✓ Job dispatched to queue!\n";
    echo "  Waiting for queue:work to process...\n\n";
    
    // Check queue
    $queueCount = \Illuminate\Support\Facades\DB::table('jobs')->count();
    echo "📊 Queued jobs: $queueCount\n\n";
    
    echo "⏳ Waiting 5 seconds for queue worker...\n";
    sleep(5);
    
    // Check job logs
    echo "\n📋 Job Logs:\n";
    $logs = \Illuminate\Support\Facades\DB::table('job_logs')
        ->where('email', $user->email)
        ->orderBy('created_at', 'desc')
        ->get();
    
    if ($logs->count() > 0) {
        foreach ($logs as $log) {
            echo "  ✓ Status: {$log->status}\n";
            echo "    Email: {$log->email}\n";
            echo "    Created: {$log->created_at}\n";
            if ($log->error_message) {
                echo "    Error: {$log->error_message}\n";
            }
        }
    } else {
        echo "  ⏳ Job logs not found yet. Waiting for queue:work...\n";
    }
    
    echo "\n✅ Test completed!\n";
    
    if ($logs->count() > 0 && $logs[0]->status === 'success') {
        echo "🎉 EMAIL SENT SUCCESSFULLY!\n";
    } else {
        echo "⚠️ Check queue:work terminal for details\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
