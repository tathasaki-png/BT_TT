<?php

namespace App\Http\Controllers;

use App\Mail\OrderCompletedMail;
use App\Models\Order;
use App\Jobs\SendOrderCompletedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Test Controller - CHỈ DÙNG CHO DEVELOPMENT
 * 
 * Hãy xóa controller này khi deploy lên production!
 * Hoặc thêm middleware authentication để bảo vệ
 */
class TestEmailController extends Controller
{
    /**
     * Test gửi email đơn hàng
     * 
     * Route: GET /test-email/{orderId}
     */
    public function testOrderCompletedEmail(Order $order)
    {
        try {
            Log::info("Testing order completed email for order #{$order->id}");
            
            // Gửi email trực tiếp
            Mail::to($order->user->email)->send(new OrderCompletedMail($order));
            
            return response()->json([
                'success' => true,
                'message' => "Email sent to {$order->user->email}",
                'order_id' => $order->id,
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to send test email: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ], 500);
        }
    }

    /**
     * Test gửi email via Job (async)
     * 
     * Route: GET /test-email-job/{orderId}
     */
    public function testOrderCompletedEmailJob(Order $order)
    {
        try {
            Log::info("Testing order completed email job for order #{$order->id}");
            
            // Dispatch job để xử lý async
            SendOrderCompletedNotification::dispatch($order);
            
            return response()->json([
                'success' => true,
                'message' => "Email job dispatched for order #{$order->id}",
                'order_id' => $order->id,
                'hint' => 'Run "php artisan queue:work" to process jobs',
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to dispatch email job: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ], 500);
        }
    }

    /**
     * Test gửi email sync (đồng bộ)
     * 
     * Route: GET /test-email-sync/{orderId}
     */
    public function testOrderCompletedEmailSync(Order $order)
    {
        try {
            Log::info("Testing order completed email sync for order #{$order->id}");
            
            // Dispatch sync - chờ email gửi xong
            SendOrderCompletedNotification::dispatchSync($order);
            
            return response()->json([
                'success' => true,
                'message' => "Email sent synchronously to {$order->user->email}",
                'order_id' => $order->id,
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to send sync email: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ], 500);
        }
    }

    /**
     * Mock VNPAY callback
     * 
     * Route: GET /test-vnpay-return
     */
    public function testVnpayReturn(Request $request)
    {
        $orderId = $request->query('order_id', 1);
        $order = Order::findOrFail($orderId);
        
        try {
            Log::info("Mock VNPAY return for order #{$orderId}");
            
            // Giả lập VNPAY callback
            $order->update(['status' => 'completed']);
            $order->user->courses()->syncWithoutDetaching(
                $order->items->pluck('course_id')->toArray()
            );
            
            SendOrderCompletedNotification::dispatch($order);
            
            return response()->json([
                'success' => true,
                'message' => "Mock VNPAY payment successful for order #{$orderId}",
                'email_job_dispatched' => true,
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to mock VNPAY return: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Xem email content (HTML)
     * 
     * Route: GET /test-email-preview/{orderId}
     */
    public function previewOrderEmail(Order $order)
    {
        return new OrderCompletedMail($order);
    }

    /**
     * Xem logs
     * 
     * Route: GET /test-logs
     */
    public function viewLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }
        
        $lines = file_get_contents($logFile);
        
        return response()->json([
            'log_file' => $logFile,
            'content' => $lines,
        ]);
    }

    /**
     * Xem queue jobs
     * 
     * Route: GET /test-queue-status
     */
    public function queueStatus()
    {
        try {
            $pendingJobs = \DB::table('jobs')->count();
            $failedJobs = \DB::table('failed_jobs')->count();
            
            return response()->json([
                'pending_jobs' => $pendingJobs,
                'failed_jobs' => $failedJobs,
                'queue_connection' => config('queue.default'),
                'hint' => 'Run "php artisan queue:work" to process pending jobs',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Database queue tables not found. Run: php artisan migrate',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
