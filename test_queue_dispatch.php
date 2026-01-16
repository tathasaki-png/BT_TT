<?php
// Test script để tạo user và dispatch job

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\DB;

try {
    echo "=== Test Queue Job Dispatch ===\n\n";
    
    // Tạo user mới
    $user = User::create([
        'name' => 'Test User - ' . date('H:i:s'),
        'email' => 'test' . time() . '@example.com',
        'password' => bcrypt('password123'),
    ]);
    
    echo "✓ Created user: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  ID: {$user->id}\n\n";
    
    // Dispatch job
    SendWelcomeEmailJob::dispatch($user->email, $user->name);
    
    echo "✓ Job dispatched to queue!\n";
    echo "  Queue worker sẽ xử lý trong vài giây...\n\n";
    
    // Check queue
    $queueCount = DB::table('jobs')->count();
    echo "📊 Queued jobs: $queueCount\n\n";
    
    // Check job logs
    echo "📋 Job Logs:\n";
    $logs = DB::table('job_logs')
        ->where('email', $user->email)
        ->orderBy('created_at', 'desc')
        ->get();
    
    foreach ($logs as $log) {
        echo "  - Status: {$log->status}\n";
        echo "    Email: {$log->email}\n";
        echo "    Created: {$log->created_at}\n";
    }
    
    echo "\n✅ Test completed!\n";
    echo "\n💡 Mở http://localhost:8000/dashboard để xem job logs\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
