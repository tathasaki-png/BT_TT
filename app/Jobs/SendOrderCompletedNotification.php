<?php

namespace App\Jobs;

use App\Mail\OrderCompletedMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendOrderCompletedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    
    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;
    
    /**
     * The maximum number of seconds the job can run for.
     */
    public int $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        // Set the queue to ensure emails are processed promptly
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->order->user?->email;
        
        if (!$email) {
            Log::warning("No email found for order #{$this->order->id}");
            return;
        }

        try {
            Log::info("Sending order completion email to {$email} for order #{$this->order->id}");
            
            Mail::to($email)->send(new OrderCompletedMail($this->order));
            
            Log::info("Order completion email sent successfully to {$email} for order #{$this->order->id}");
        } catch (Throwable $e) {
            Log::error(
                "Failed to send order completion email for order #{$this->order->id} to {$email}",
                ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
            );
            
            // Re-throw to trigger retry logic
            throw $e;
        }
    }
    
    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        $email = $this->order->user?->email;
        
        Log::error(
            "Job failed permanently for order completion email to {$email} (Order #{$this->order->id})",
            ['exception' => $exception->getMessage()]
        );
    }
}
