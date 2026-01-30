<?php

namespace App\Jobs;

use App\Mail\CODOrderReceivedMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendCODOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    public int $tries = 3;
    public int $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->order->user?->email;
        
        if (!$email) {
            Log::warning("No email found for COD order #{$this->order->id}");
            return;
        }

        try {
            Mail::to($email)->send(new CODOrderReceivedMail($this->order));
            Log::info("COD order notification email sent successfully to {$email} for order #{$this->order->id}");
        } catch (Throwable $e) {
            Log::error("Failed to send COD order notification for order #{$this->order->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
