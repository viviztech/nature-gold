<?php

namespace App\Notifications;

use App\Models\Dealer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DealerRejectedNotification extends Notification implements ShouldQueue
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
        $mail = (new MailMessage)
            ->subject('Dealer Application Update - ' . config('app.name'))
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('We\'ve reviewed your dealer application for **' . $this->dealer->business_name . '**.');

        if ($this->dealer->rejection_reason) {
            $mail->line('Unfortunately, we are unable to approve your application at this time.')
                ->line('**Reason:** ' . $this->dealer->rejection_reason);
        } else {
            $mail->line('Unfortunately, we are unable to approve your application at this time.');
        }

        return $mail
            ->line('If you have questions or would like to reapply, please contact our support team.')
            ->action('Contact Us', route('contact'))
            ->line('Thank you for your interest in partnering with ' . config('app.name') . '.');
    }
}
