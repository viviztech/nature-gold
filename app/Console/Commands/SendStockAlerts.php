<?php

namespace App\Console\Commands;

use App\Mail\BackInStockNotification;
use App\Models\StockAlert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendStockAlerts extends Command
{
    protected $signature = 'alerts:stock';

    protected $description = 'Send back-in-stock notifications to subscribed users';

    public function handle(): void
    {
        $alerts = StockAlert::whereNull('notified_at')
            ->with(['user', 'product', 'variant'])
            ->get();

        $sent = 0;

        foreach ($alerts as $alert) {
            $stock = $alert->variant
                ? $alert->variant->stock
                : $alert->product->stock;

            if ($stock <= 0) {
                continue;
            }

            if ($alert->user?->email) {
                Mail::to($alert->user->email)
                    ->queue(new BackInStockNotification($alert));
            }

            $alert->update(['notified_at' => now()]);
            $sent++;
        }

        $this->info("Sent {$sent} back-in-stock alerts.");
        Log::info("Back-in-stock alerts sent: {$sent}");
    }
}
