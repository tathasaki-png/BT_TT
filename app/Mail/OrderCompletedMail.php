<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCompletedMail extends Mailable
{
    use SerializesModels;

    public Order $order;

    /**
     * Create a new message instance.
     * 
     * @param Order $order The completed order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $orderNumber = str_pad($this->order->id, 5, '0', STR_PAD_LEFT);
        
        return new Envelope(
            from: config('mail.from.address'),
            replyTo: config('mail.from.address'),
            subject: "Xác nhận đơn hàng #{$orderNumber} - Thanh toán thành công",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Load order items to ensure relationships are available in template
        $this->order->load(['items.course', 'user']);
        
        return new Content(
            view: 'emails.order-completed',
            with: [
                'order' => $this->order,
                'orderNumber' => str_pad($this->order->id, 5, '0', STR_PAD_LEFT),
                'userName' => $this->order->user->name,
                'totalPrice' => (int) $this->order->total_price,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
