#!/usr/bin/env php
<?php
/**
 * Test Script for VNPAY Order Completion Email
 * 
 * Usage:
 * php artisan tinker < this-script.php
 * 
 * OR manually in tinker:
 * php artisan tinker
 * > // Copy-paste code from here
 */

echo "=== VNPAY Order Email Test Script ===\n\n";

// 1. Check Environment
echo "1. Environment Configuration\n";
echo "   MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "   MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "   QUEUE_CONNECTION: " . config('queue.default') . "\n";
echo "\n";

// 2. Check Mail Config
echo "2. Mail Configuration\n";
$mailConfig = config('mail');
echo "   From: " . ($mailConfig['from']['address'] ?? 'NOT SET') . "\n";
echo "   Driver: " . $mailConfig['default'] . "\n";
echo "\n";

// 3. Find test order
echo "3. Finding test order...\n";
$order = App\Models\Order::with(['user', 'items.course'])->first();

if (!$order) {
    echo "   ERROR: No orders found in database!\n";
    echo "   Create an order first through checkout process.\n";
    exit(1);
}

echo "   Order ID: " . $order->id . "\n";
echo "   User: " . $order->user->name . " (" . $order->user->email . ")\n";
echo "   Status: " . $order->status . "\n";
echo "   Courses: " . $order->items->count() . "\n";
echo "\n";

// 4. Test Email Mailable
echo "4. Testing Email Mailable...\n";
try {
    $mailable = new App\Mail\OrderCompletedMail($order);
    echo "   ✓ Email object created successfully\n";
    echo "   Subject: " . $mailable->envelope()->subject . "\n";
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
echo "\n";

// 5. Test Send Email (Sync)
echo "5. Sending Test Email (Synchronous)...\n";
try {
    Illuminate\Support\Facades\Mail::to($order->user->email)->send(new App\Mail\OrderCompletedMail($order));
    echo "   ✓ Email sent successfully to " . $order->user->email . "\n";
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
    echo "   Check your .env MAIL_* settings\n";
}
echo "\n";

// 6. Test Job Dispatch
echo "6. Testing Job Dispatch...\n";
try {
    App\Jobs\SendOrderCompletedNotification::dispatch($order);
    echo "   ✓ Job dispatched successfully\n";
    echo "   Note: If using database queue, run: php artisan queue:work\n";
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}
echo "\n";

// 7. Check Queue Status
if (config('queue.default') === 'database') {
    echo "7. Queue Status\n";
    $pendingJobs = DB::table('jobs')->count();
    $failedJobs = DB::table('failed_jobs')->count();
    echo "   Pending jobs: " . $pendingJobs . "\n";
    echo "   Failed jobs: " . $failedJobs . "\n";
    echo "   To process jobs, run: php artisan queue:work\n";
}
echo "\n";

echo "=== Test Complete ===\n";
echo "\nNext Steps:\n";
echo "1. Check email inbox: " . $order->user->email . "\n";
echo "2. If using database queue, run: php artisan queue:work\n";
echo "3. Check logs: tail -f storage/logs/laravel.log\n";
echo "4. Test VNPAY callback: GET /test-vnpay-return?order_id=" . $order->id . "\n";
