<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$logs = \DB::table('job_logs')
    ->orderBy('id', 'desc')
    ->limit(5)
    ->get();

echo "Total job_logs: " . count($logs) . "\n\n";

foreach ($logs as $log) {
    echo "ID: {$log->id}\n";
    echo "Email: {$log->email}\n";
    echo "Status: {$log->status}\n";
    echo "Error: " . ($log->error_message ? substr($log->error_message, 0, 200) : "None") . "\n";
    echo "Created: {$log->created_at}\n";
    echo "---\n";
}
