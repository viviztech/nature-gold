<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected NotificationService $notificationService,
    ) {}
    /**
     * Transition order to a new status with validation.
     */
    public function updateStatus(Order $order, OrderStatus $newStatus): bool
    {
        $allowedTransitions = $this->getAllowedTransitions($order->status);

        if (! in_array($newStatus, $allowedTransitions)) {
            return false;
        }

        return DB::transaction(function () use ($order, $newStatus) {
            $updates = ['status' => $newStatus];

            match ($newStatus) {
                OrderStatus::Confirmed => $updates['confirmed_at'] = now(),
                OrderStatus::Shipped => $updates['shipped_at'] = now(),
                OrderStatus::Delivered => $updates = array_merge($updates, [
                    'delivered_at' => now(),
                    'payment_status' => $order->payment_method->value === 'cod'
                        ? PaymentStatus::Paid
                        : $order->payment_status,
                ]),
                OrderStatus::Cancelled => $updates = array_merge($updates, [
                    'cancelled_at' => now(),
                ]),
                default => null,
            };

            $order->update($updates);

            // Restore stock on cancellation
            if ($newStatus === OrderStatus::Cancelled) {
                $this->restoreStock($order);
            }

            // Send notifications based on new status
            $this->sendStatusNotification($order, $newStatus);

            return true;
        });
    }

    /**
     * Send notification for order status change.
     */
    protected function sendStatusNotification(Order $order, OrderStatus $status): void
    {
        try {
            match ($status) {
                OrderStatus::Confirmed => $this->notificationService->orderConfirmed($order),
                OrderStatus::Shipped => $this->notificationService->orderShipped($order),
                OrderStatus::Delivered => $this->notificationService->orderDelivered($order),
                default => null,
            };
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Order notification failed', [
                'order' => $order->id,
                'status' => $status->value,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get allowed status transitions from current status.
     */
    public function getAllowedTransitions(OrderStatus $currentStatus): array
    {
        return match ($currentStatus) {
            OrderStatus::Pending => [OrderStatus::Confirmed, OrderStatus::Cancelled],
            OrderStatus::Confirmed => [OrderStatus::Processing, OrderStatus::Cancelled],
            OrderStatus::Processing => [OrderStatus::Shipped, OrderStatus::Cancelled],
            OrderStatus::Shipped => [OrderStatus::Delivered, OrderStatus::Returned],
            OrderStatus::Delivered => [OrderStatus::Returned],
            OrderStatus::Cancelled, OrderStatus::Returned => [],
        };
    }

    /**
     * Cancel an order with stock restoration and optional refund.
     */
    public function cancel(Order $order, ?string $reason = null): bool
    {
        if (in_array($order->status, [OrderStatus::Cancelled, OrderStatus::Delivered, OrderStatus::Returned])) {
            return false;
        }

        return DB::transaction(function () use ($order, $reason) {
            $order->update([
                'status' => OrderStatus::Cancelled,
                'cancelled_at' => now(),
                'admin_notes' => $reason
                    ? ($order->admin_notes ? $order->admin_notes . "\n" : '') . "Cancelled: {$reason}"
                    : $order->admin_notes,
            ]);

            $this->restoreStock($order);

            return true;
        });
    }

    /**
     * Restore stock for cancelled/returned orders.
     */
    protected function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_variant_id) {
                $item->variant?->increment('stock', $item->quantity);
            } else {
                $item->product?->increment('stock', $item->quantity);
            }
        }
    }

    /**
     * Get order status timeline for display.
     */
    public function getTimeline(Order $order): array
    {
        $steps = [
            [
                'label' => __('shop.order_placed'),
                'status' => 'completed',
                'date' => $order->created_at,
            ],
        ];

        if ($order->status === OrderStatus::Cancelled) {
            $steps[] = [
                'label' => __('shop.order_cancelled'),
                'status' => 'cancelled',
                'date' => $order->cancelled_at,
            ];
            return $steps;
        }

        $statusMap = [
            ['status' => OrderStatus::Confirmed, 'label' => __('shop.order_confirmed_step'), 'date' => $order->confirmed_at],
            ['status' => OrderStatus::Processing, 'label' => __('shop.order_processing'), 'date' => null],
            ['status' => OrderStatus::Shipped, 'label' => __('shop.order_shipped'), 'date' => $order->shipped_at],
            ['status' => OrderStatus::Delivered, 'label' => __('shop.order_delivered'), 'date' => $order->delivered_at],
        ];

        $currentReached = false;
        foreach ($statusMap as $step) {
            if ($order->status === $step['status']) {
                $steps[] = [
                    'label' => $step['label'],
                    'status' => 'current',
                    'date' => $step['date'],
                ];
                $currentReached = true;
            } elseif (! $currentReached && $step['date']) {
                $steps[] = [
                    'label' => $step['label'],
                    'status' => 'completed',
                    'date' => $step['date'],
                ];
            } elseif ($currentReached || ! $step['date']) {
                $steps[] = [
                    'label' => $step['label'],
                    'status' => 'pending',
                    'date' => null,
                ];
            }
        }

        return $steps;
    }
}
