<?php

$logFile = __DIR__ . '/storage/logs/laravel.log';

// Lấy 50 dòng cuối
$lines = [];
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lines = array_slice($lines, -100);
}

echo "=== Last 100 lines of Laravel Log ===\n\n";

$lastErrors = [];
foreach ($lines as $line) {
    if (stripos($line, 'error') !== false || 
        stripos($line, 'failed') !== false || 
        stripos($line, 'exception') !== false ||
        stripos($line, '✅') !== false ||
        stripos($line, 'SMTP') !== false ||
        stripos($line, 'email') !== false) {
        $lastErrors[] = trim($line);
    }
}

if (!empty($lastErrors)) {
    echo "Error/Important messages:\n";
    foreach (array_slice($lastErrors, -20) as $error) {
        echo $error . "\n";
    }
} else {
    echo "No errors found. Last 20 lines:\n";
    foreach (array_slice($lines, -20) as $line) {
        echo trim($line) . "\n";
    }
}
