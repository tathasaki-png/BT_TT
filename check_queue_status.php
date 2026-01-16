<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

echo "Queue configuration: " . config('queue.default') . "\n";
echo "Queue connection: " . env('QUEUE_CONNECTION') . "\n\n";

// Check jobs table
$jobs = \DB::table('jobs')->get();
echo "Total jobs in queue: " . count($jobs) . "\n";

if (count($jobs) > 0) {
    echo "\nLatest 3 jobs:\n";
    foreach ($jobs->take(3) as $job) {
        echo "- ID: {$job->id} | Queue: {$job->queue} | Attempts: {$job->attempts} | Created: {$job->created_at}\n";
    }
}

// Check failed jobs
$failedJobs = \DB::table('failed_jobs')->get();
echo "\n\nTotal failed jobs: " . count($failedJobs) . "\n";

if (count($failedJobs) > 0) {
    echo "Latest 3 failed jobs:\n";
    foreach ($failedJobs->take(3) as $failed) {
        echo "- ID: {$failed->id} | Exception: " . substr($failed->exception, 0, 100) . "...\n";
    }
}
