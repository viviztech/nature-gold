<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Order $order,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Delivered - ' . $this->order->order_number)
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line('Your order **' . $this->order->order_number . '** has been delivered!')
            ->line('We hope you enjoy your products. Your feedback helps us improve.')
            ->action('View Order', route('account.orders.show', $this->order))
            ->line('Thank you for choosing ' . config('app.name') . '!');
    }
}
