<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->boot();

echo "=== Checking Latest Job Logs ===\n\n";

$logs = \Illuminate\Support\Facades\DB::table('job_logs')
    ->orderBy('id', 'desc')
    ->limit(10)
    ->get();

foreach ($logs as $log) {
    echo "ID: {$log->id}\n";
    echo "Email: {$log->email}\n";
    echo "Status: {$log->status}\n";
    echo "Error: " . ($log->error_message ?? "None") . "\n";
    echo "Retry: {$log->retry_count}/{$log->max_retries}\n";
    echo "Created: {$log->created_at}\n";
    echo "---\n";
}

// Also check jobs table
echo "\n=== Jobs Queue Status ===\n";
$jobs = \Illuminate\Support\Facades\DB::table('jobs')->get();
echo "Total queued jobs: " . count($jobs) . "\n";

foreach ($jobs as $job) {
    echo "Job ID: {$job->id} | Queue: {$job->queue} | Attempts: {$job->attempts}\n";
}

// Check if queue:listen is running
echo "\n=== Queue Listener Check ===\n";
exec('tasklist /FI "IMAGENAME eq php.exe"', $output);
foreach ($output as $line) {
    if (stripos($line, 'php') !== false) {
        echo $line . "\n";
    }
}
