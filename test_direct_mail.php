<?php
require 'vendor/autoload.php';

echo "=== Testing Direct Email Sending ===\n\n";

// Setup Mail config
putenv('MAIL_DRIVER=smtp');
putenv('MAIL_SCHEME=smtp');
putenv('MAIL_HOST=smtp.gmail.com');
putenv('MAIL_PORT=587');
putenv('MAIL_USERNAME=tat.hasaki@gmail.com');
putenv('MAIL_PASSWORD=byld dmcw oilu tiwj');
putenv('MAIL_FROM_ADDRESS=tat.hasaki@gmail.com');
putenv('MAIL_FROM_NAME=TTCK Bai 8');

// Bootstrap Laravel
$app = require 'bootstrap/app.php';

// Send raw email using Laravel mailer
$mailer = $app['mail.mailer'];

echo "Mailer Instance: " . get_class($mailer) . "\n";
echo "SMTP Config: " . config('mail.driver') . "\n";

try {
    // Create inline mail
    $result = \Illuminate\Support\Facades\Mail::raw('This is a test email body', function ($message) {
        $message
            ->to('tat.hasaki@gmail.com')
            ->subject('Test Email - ' . date('Y-m-d H:i:s'));
    });
    
    echo "✅ Email sent successfully!\n";
    var_dump($result);
    
} catch (Exception $e) {
    echo "❌ Error sending email:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
