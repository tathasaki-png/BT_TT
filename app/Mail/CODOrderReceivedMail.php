<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CODOrderReceivedMail extends Mailable
{
    use SerializesModels;

    public Order $order;

    /**
     * Create a new message instance.
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
            subject: "Đơn hàng #{$orderNumber} đã đặt thành công (COD) - " . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $this->order->load(['items.course', 'user']);
        
        return new Content(
            view: 'emails.cod-order-received',
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
     */
    public function attachments(): array
    {
        return [];
    }
}
