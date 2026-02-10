<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification implements ShouldQueue
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
            ->subject('Order Confirmed - ' . $this->order->order_number)
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line('Your order **' . $this->order->order_number . '** has been confirmed.')
            ->line('**Total:** ₹' . number_format($this->order->total, 2))
            ->line('**Payment:** ' . $this->order->payment_method->label())
            ->line('**Items:** ' . $this->order->items()->count())
            ->action('View Order', route('account.orders.show', $this->order))
            ->line('We\'ll notify you when your order ships. Thank you for shopping with ' . config('app.name') . '!');
    }
}
