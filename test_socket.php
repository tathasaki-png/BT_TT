<?php
$host = 'smtp.googlemail.com';
$port = 587;
$timeout = 10;

$fp = @fsockopen($host, $port, $errno, $errstr, $timeout);

if (!$fp) {
    echo "FAILED: $errstr ($errno)\n";
} else {
    echo "SUCCESS: Connected to $host on port $port\n";
    fclose($fp);
}

$port = 465;
$fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
if (!$fp) {
    echo "FAILED: $errstr ($errno)\n";
} else {
    echo "SUCCESS: Connected to $host on port $port\n";
    fclose($fp);
}
