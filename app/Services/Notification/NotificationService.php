<?php

namespace App\Services\Notification;

use App\Models\Dealer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(
        protected WhatsAppService $whatsApp,
        protected SmsService $sms,
    ) {}

    /**
     * Order confirmed notification (customer).
     */
    public function orderConfirmed(Order $order): void
    {
        $user = $order->user;
        if (! $user) {
            return;
        }

        $phone = $user->phone ?? $order->shipping_address['phone'] ?? null;

        // WhatsApp notification
        if ($phone) {
            $this->whatsApp->sendText($phone, $this->buildOrderConfirmedMessage($order));
        }

        // Email notification
        $this->sendMail($user, new \App\Notifications\OrderConfirmedNotification($order));
    }

    /**
     * Order shipped notification (customer).
     */
    public function orderShipped(Order $order): void
    {
        $user = $order->user;
        if (! $user) {
            return;
        }

        $phone = $user->phone ?? $order->shipping_address['phone'] ?? null;

        if ($phone) {
            $this->whatsApp->sendText($phone, $this->buildOrderShippedMessage($order));
        }

        $this->sendMail($user, new \App\Notifications\OrderShippedNotification($order));
    }

    /**
     * Order delivered notification (customer).
     */
    public function orderDelivered(Order $order): void
    {
        $user = $order->user;
        if (! $user) {
            return;
        }

        $phone = $user->phone ?? $order->shipping_address['phone'] ?? null;

        if ($phone) {
            $this->whatsApp->sendText($phone, $this->buildOrderDeliveredMessage($order));
        }

        $this->sendMail($user, new \App\Notifications\OrderDeliveredNotification($order));
    }

    /**
     * Payment received notification (customer).
     */
    public function paymentReceived(Order $order): void
    {
        $user = $order->user;
        if (! $user) {
            return;
        }

        $phone = $user->phone ?? $order->shipping_address['phone'] ?? null;

        if ($phone) {
            $message = "✅ *Payment Received*\n\n"
                . "Hi {$user->name},\n"
                . "We've received ₹" . number_format($order->total, 2) . " for order *{$order->order_number}*.\n"
                . "Your order is being processed.\n\n"
                . "— " . config('app.name');

            $this->whatsApp->sendText($phone, $message);
        }
    }

    /**
     * Dealer application approved notification.
     */
    public function dealerApproved(Dealer $dealer): void
    {
        $user = $dealer->user;
        if (! $user) {
            return;
        }

        $phone = $user->phone;
        $dashboardUrl = route('dealer.dashboard');

        if ($phone) {
            $message = "🎉 *Congratulations!*\n\n"
                . "Hi {$user->name},\n"
                . "Your dealer application for *{$dealer->business_name}* has been approved!\n\n"
                . "You can now access your dealer dashboard and start placing bulk orders at special prices.\n\n"
                . "Dashboard: {$dashboardUrl}\n\n"
                . "— " . config('app.name');

            $this->whatsApp->sendText($phone, $message);
        }

        $this->sendMail($user, new \App\Notifications\DealerApprovedNotification($dealer));
    }

    /**
     * Dealer application rejected notification.
     */
    public function dealerRejected(Dealer $dealer): void
    {
        $user = $dealer->user;
        if (! $user) {
            return;
        }

        $phone = $user->phone;

        if ($phone) {
            $message = "Hi {$user->name},\n\n"
                . "We regret to inform you that your dealer application for *{$dealer->business_name}* has not been approved at this time.\n\n";

            if ($dealer->rejection_reason) {
                $message .= "Reason: {$dealer->rejection_reason}\n\n";
            }

            $message .= "You can contact us for more information.\n\n— " . config('app.name');

            $this->whatsApp->sendText($phone, $message);
        }

        $this->sendMail($user, new \App\Notifications\DealerRejectedNotification($dealer));
    }

    /**
     * Abandoned cart reminder (customer).
     */
    public function abandonedCartReminder(User $user, int $itemCount, float $total): void
    {
        $phone = $user->phone;

        if ($phone) {
            $cartUrl = route('cart');
            $message = "🛒 *You left items in your cart!*\n\n"
                . "Hi {$user->name},\n"
                . "You have {$itemCount} item(s) worth ₹" . number_format($total, 2) . " waiting in your cart.\n\n"
                . "Complete your purchase: {$cartUrl}\n\n"
                . "— " . config('app.name');

            $this->whatsApp->sendText($phone, $message);
        }

        $this->sendMail($user, new \App\Notifications\AbandonedCartNotification($itemCount, $total));
    }

    /**
     * Build order confirmed message.
     */
    protected function buildOrderConfirmedMessage(Order $order): string
    {
        $user = $order->user;
        $itemCount = $order->items()->count();

        return "🧾 *Order Confirmed*\n\n"
            . "Hi {$user->name},\n"
            . "Your order *{$order->order_number}* has been confirmed!\n\n"
            . "📦 Items: {$itemCount}\n"
            . "💰 Total: ₹" . number_format($order->total, 2) . "\n"
            . "💳 Payment: " . $order->payment_method->label() . "\n\n"
            . "We'll notify you when your order ships.\n\n"
            . "— " . config('app.name');
    }

    /**
     * Build order shipped message.
     */
    protected function buildOrderShippedMessage(Order $order): string
    {
        $user = $order->user;
        $message = "🚚 *Order Shipped*\n\n"
            . "Hi {$user->name},\n"
            . "Your order *{$order->order_number}* has been shipped!\n\n";

        if ($order->tracking_number) {
            $message .= "📍 Tracking: {$order->tracking_number}\n";
        }

        if ($order->tracking_url) {
            $message .= "🔗 Track here: {$order->tracking_url}\n";
        }

        $message .= "\n— " . config('app.name');

        return $message;
    }

    /**
     * Build order delivered message.
     */
    protected function buildOrderDeliveredMessage(Order $order): string
    {
        $user = $order->user;

        return "✅ *Order Delivered*\n\n"
            . "Hi {$user->name},\n"
            . "Your order *{$order->order_number}* has been delivered!\n\n"
            . "We hope you love your products. If you have any questions, feel free to reach out.\n\n"
            . "— " . config('app.name');
    }

    /**
     * Send a mail notification safely.
     */
    protected function sendMail(User $user, $notification): void
    {
        try {
            $user->notify($notification);
        } catch (\Exception $e) {
            Log::error('Mail notification failed', [
                'user' => $user->id,
                'notification' => get_class($notification),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
