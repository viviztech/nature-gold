<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbandonedCartNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected int $itemCount,
        protected float $total,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You left items in your cart! - ' . config('app.name'))
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line('You have **' . $this->itemCount . ' item(s)** worth **₹' . number_format($this->total, 2) . '** waiting in your cart.')
            ->line('Complete your purchase before they sell out!')
            ->action('Complete Your Order', route('cart'))
            ->line('Need help? Our support team is here for you.');
    }
}
