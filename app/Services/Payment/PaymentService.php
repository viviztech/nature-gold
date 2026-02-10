<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use InvalidArgumentException;

class PaymentService
{
    /**
     * Resolve the payment gateway for a given method.
     */
    public function gateway(PaymentMethod|string $method): PaymentGatewayInterface
    {
        if ($method instanceof PaymentMethod) {
            $method = $method->value;
        }

        return match ($method) {
            'razorpay' => app(RazorpayGateway::class),
            'phonepe' => app(PhonePeGateway::class),
            'cod' => app(CodGateway::class),
            default => throw new InvalidArgumentException("Unsupported payment method: {$method}"),
        };
    }

    /**
     * Initiate payment for an order.
     */
    public function initiate(Order $order): array
    {
        $gateway = $this->gateway($order->payment_method);
        $result = $gateway->createPaymentOrder($order);

        // Record the pending transaction
        if ($order->payment_method !== PaymentMethod::COD) {
            $order->transactions()->create([
                'gateway' => $gateway->getName(),
                'transaction_id' => $result['razorpay_order_id']
                    ?? $result['transaction_id']
                    ?? 'pending_' . uniqid(),
                'amount' => $order->total,
                'currency' => 'INR',
                'status' => 'pending',
                'gateway_response' => $result,
            ]);
        }

        return $result;
    }

    /**
     * Confirm payment after gateway callback.
     */
    public function confirm(Order $order, array $payload): bool
    {
        $gateway = $this->gateway($order->payment_method);
        $result = $gateway->verifyPayment($payload);

        if ($result['success']) {
            // Update or create the transaction
            $order->transactions()->updateOrCreate(
                ['gateway' => $gateway->getName(), 'order_id' => $order->id],
                [
                    'transaction_id' => $result['transaction_id'],
                    'amount' => $order->total,
                    'currency' => 'INR',
                    'status' => 'success',
                    'gateway_response' => $result['gateway_response'],
                ]
            );

            $order->update([
                'payment_status' => PaymentStatus::Paid,
                'status' => OrderStatus::Confirmed,
                'confirmed_at' => now(),
            ]);

            // Decrement stock
            $this->decrementStock($order);

            return true;
        }

        // Payment failed
        $order->transactions()->updateOrCreate(
            ['gateway' => $gateway->getName(), 'order_id' => $order->id],
            [
                'transaction_id' => $result['transaction_id'] ?? null,
                'amount' => $order->total,
                'currency' => 'INR',
                'status' => 'failed',
                'gateway_response' => $result['gateway_response'] ?? $result,
            ]
        );

        $order->update([
            'payment_status' => PaymentStatus::Failed,
        ]);

        return false;
    }

    /**
     * Handle COD order placement (no online payment needed).
     */
    public function handleCod(Order $order): bool
    {
        $order->transactions()->create([
            'gateway' => 'cod',
            'transaction_id' => 'COD_' . $order->order_number,
            'amount' => $order->total,
            'currency' => 'INR',
            'status' => 'pending',
            'gateway_response' => ['method' => 'cod'],
        ]);

        $order->update([
            'payment_status' => PaymentStatus::Pending,
            'status' => OrderStatus::Confirmed,
            'confirmed_at' => now(),
        ]);

        // Decrement stock
        $this->decrementStock($order);

        return true;
    }

    /**
     * Process a refund for an order.
     */
    public function refund(Order $order, ?float $amount = null): array
    {
        $amount = $amount ?? $order->total;
        $gateway = $this->gateway($order->payment_method);
        $result = $gateway->refund($order, $amount);

        if ($result['success']) {
            $order->transactions()->create([
                'gateway' => $gateway->getName(),
                'transaction_id' => $result['refund_id'] ?? 'refund_' . uniqid(),
                'amount' => $amount,
                'currency' => 'INR',
                'status' => 'refunded',
                'gateway_response' => $result['gateway_response'] ?? $result,
            ]);

            $order->update([
                'payment_status' => PaymentStatus::Refunded,
            ]);
        }

        return $result;
    }

    /**
     * Decrement product stock after successful order.
     */
    protected function decrementStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_variant_id) {
                $item->variant?->decrement('stock', $item->quantity);
            } else {
                $item->product?->decrement('stock', $item->quantity);
            }
        }
    }
}
