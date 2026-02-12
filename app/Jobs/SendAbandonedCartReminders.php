<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Services\Notification\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAbandonedCartReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(NotificationService $notificationService): void
    {
        // Find carts updated 2-24 hours ago with items, belonging to logged-in users, not yet reminded
        $abandonedCarts = Cart::whereNotNull('user_id')
            ->whereNull('reminder_sent_at')
            ->where('updated_at', '<=', now()->subHours(2))
            ->where('updated_at', '>=', now()->subHours(24))
            ->whereHas('items')
            ->with(['user', 'items.product', 'items.variant'])
            ->get();

        $sent = 0;

        foreach ($abandonedCarts as $cart) {
            $user = $cart->user;

            if (! $user || ! $user->phone) {
                continue;
            }

            // Skip if user already placed an order in the last 2 hours
            $recentOrder = $user->orders()
                ->where('created_at', '>=', now()->subHours(2))
                ->exists();

            if ($recentOrder) {
                continue;
            }

            $itemCount = $cart->items->sum('quantity');
            $total = $cart->subtotal;

            $notificationService->abandonedCartReminder($user, $itemCount, $total);
            $cart->update(['reminder_sent_at' => now()]);
            $sent++;
        }

        Log::info("Abandoned cart reminders sent: {$sent}");
    }
}
