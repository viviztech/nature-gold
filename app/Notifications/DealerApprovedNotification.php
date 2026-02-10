<?php

namespace App\Notifications;

use App\Models\Dealer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DealerApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Dealer $dealer,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Dealer Application Approved - ' . config('app.name'))
            ->greeting('Congratulations, ' . $notifiable->name . '!')
            ->line('Your dealer application for **' . $this->dealer->business_name . '** has been approved.')
            ->line('You can now access your dealer dashboard to:')
            ->line('- Browse products with exclusive dealer pricing')
            ->line('- Place bulk orders with special discounts')
            ->line('- Track all your orders and download invoices')
            ->action('Go to Dealer Dashboard', route('dealer.dashboard'))
            ->line('Welcome aboard! We look forward to a great partnership.');
    }
}
