<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

echo "=== Testing Symfony SMTP Connection ===\n\n";

try {
    // Get SMTP config
    $host = config('mail.mailers.smtp.host');
    $port = config('mail.mailers.smtp.port');
    $username = config('mail.mailers.smtp.username');
    $password = config('mail.mailers.smtp.password');
    $scheme = config('mail.mailers.smtp.scheme');
    
    echo "SMTP Config:\n";
    echo "  Host: $host\n";
    echo "  Port: $port\n";
    echo "  Scheme: $scheme\n";
    echo "  Username: $username\n";
    echo "  Password: " . (strlen($password) > 0 ? "***" : "EMPTY") . "\n\n";
    
    // Create DSN
    $dsn = $scheme . "://" . urlencode($username) . ":" . urlencode($password) . "@" . $host . ":" . $port;
    echo "DSN: " . str_replace(urlencode($password), "***", $dsn) . "\n\n";
    
    // Create Transport
    echo "Creating transport...\n";
    $transport = Transport::fromDsn($dsn);
    echo "✅ Transport created successfully!\n\n";
    
    // Try to send test email
    echo "Creating test email...\n";
    $email = (new Email())
        ->from(config('mail.from.address'))
        ->to('tat.hasaki@gmail.com')
        ->subject('Test SMTP Connection - ' . date('Y-m-d H:i:s'))
        ->html('<p>This is a direct SMTP test email</p>');
    
    echo "Sending email...\n";
    $result = $transport->send($email);
    
    echo "✅ Email sent successfully!\n";
    echo "Message ID: " . $result->getMessageId() . "\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Class: " . get_class($e) . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nFull trace:\n";
    echo $e->getTraceAsString() . "\n";
}
