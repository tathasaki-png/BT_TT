<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== LATEST JOB LOGS ===\n\n";

$logs = \DB::table('job_logs')->latest()->limit(3)->get();

foreach ($logs as $log) {
    echo "========================================\n";
    echo "ID: {$log->id}\n";
    echo "Email: {$log->email}\n";
    echo "Status: {$log->status}\n";
    echo "Job Name: {$log->job_name}\n";
    echo "Retry Count: {$log->retry_count}/{$log->max_retries}\n";
    echo "Created: {$log->created_at}\n";
    echo "Completed: {$log->completed_at}\n";
    
    if ($log->error_message) {
        echo "\n❌ ERROR MESSAGE:\n";
        echo $log->error_message . "\n";
    }
    
    if ($log->payload) {
        echo "\n📦 PAYLOAD:\n";
        echo json_decode($log->payload, true)['email'] . "\n";
    }
    echo "\n";
}
