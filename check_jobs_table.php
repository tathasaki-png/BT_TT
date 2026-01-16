<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$jobs = \DB::table('jobs')->get();
echo "Total jobs in queue table: " . count($jobs) . "\n";

foreach ($jobs as $job) {
    echo "\nJob ID: {$job->id}\n";
    echo "Queue: {$job->queue}\n";
    echo "Attempts: {$job->attempts}\n";
    echo "Created: {$job->created_at}\n";
    echo "Payload: " . substr($job->payload, 0, 200) . "...\n";
}

// Check failed jobs
$failed = \DB::table('failed_jobs')->get();
echo "\n\nTotal failed jobs: " . count($failed) . "\n";

foreach ($failed as $failedJob) {
    echo "\nFailed Job ID: {$failedJob->id}\n";
    echo "Exception: " . substr($failedJob->exception, 0, 300) . "\n";
}
