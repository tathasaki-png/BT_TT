<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMail extends Command
{
    protected $signature = 'mail:test {to?}';
    protected $description = 'Send a simple test email to verify mail configuration';

    public function handle()
    {
        $to = $this->argument('to') ?? env('MAIL_FROM_ADDRESS');

        try {
            Mail::raw('This is a test email from TTS application.', function ($message) use ($to) {
                $message->to($to)->subject('TTS - Test Email');
            });

            $this->info("Test email sent to: {$to}");
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test email: ' . $e->getMessage());
            return 1;
        }
    }
}
