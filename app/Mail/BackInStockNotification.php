<?php

namespace App\Mail;

use App\Models\StockAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackInStockNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public StockAlert $alert) {}

    public function envelope(): Envelope
    {
        $productName = $this->alert->product->name_en;

        return new Envelope(
            subject: "{$productName} is back in stock! - Nature Gold",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.back-in-stock',
            with: [
                'product' => $this->alert->product,
                'variant' => $this->alert->variant,
                'user' => $this->alert->user,
            ],
        );
    }
}
