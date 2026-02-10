<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification implements ShouldQueue
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
        $mail = (new MailMessage)
            ->subject('Order Shipped - ' . $this->order->order_number)
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line('Great news! Your order **' . $this->order->order_number . '** has been shipped.');

        if ($this->order->tracking_number) {
            $mail->line('**Tracking Number:** ' . $this->order->tracking_number);
        }

        if ($this->order->tracking_url) {
            $mail->action('Track Your Order', $this->order->tracking_url);
        } else {
            $mail->action('View Order', route('account.orders.show', $this->order));
        }

        return $mail->line('Thank you for shopping with ' . config('app.name') . '!');
    }
}
