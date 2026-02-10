<?php

namespace App\Services\Payment;

use App\Models\Order;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayGateway implements PaymentGatewayInterface
{
    protected Api $api;

    protected string $keyId;

    public function __construct()
    {
        $this->keyId = config('services.razorpay.key');
        $this->api = new Api($this->keyId, config('services.razorpay.secret'));
    }

    public function createPaymentOrder(Order $order): array
    {
        $razorpayOrder = $this->api->order->create([
            'receipt' => $order->order_number,
            'amount' => (int) round($order->total * 100), // Amount in paise
            'currency' => 'INR',
            'notes' => [
                'order_number' => $order->order_number,
                'order_id' => $order->id,
            ],
        ]);

        return [
            'razorpay_order_id' => $razorpayOrder->id,
            'razorpay_key' => $this->keyId,
            'amount' => $razorpayOrder->amount,
            'currency' => 'INR',
            'name' => config('app.name'),
            'description' => "Order #{$order->order_number}",
            'prefill' => [
                'name' => $order->shipping_address['name'] ?? '',
                'email' => $order->user?->email ?? '',
                'contact' => $order->shipping_address['phone'] ?? '',
            ],
        ];
    }

    public function verifyPayment(array $payload): array
    {
        try {
            $attributes = [
                'razorpay_order_id' => $payload['razorpay_order_id'],
                'razorpay_payment_id' => $payload['razorpay_payment_id'],
                'razorpay_signature' => $payload['razorpay_signature'],
            ];

            $this->api->utility->verifyPaymentSignature($attributes);

            $payment = $this->api->payment->fetch($payload['razorpay_payment_id']);

            return [
                'success' => true,
                'transaction_id' => $payload['razorpay_payment_id'],
                'gateway_order_id' => $payload['razorpay_order_id'],
                'gateway_response' => $payment->toArray(),
            ];
        } catch (SignatureVerificationError $e) {
            return [
                'success' => false,
                'transaction_id' => $payload['razorpay_payment_id'] ?? null,
                'gateway_response' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function refund(Order $order, float $amount): array
    {
        $transaction = $order->transactions()
            ->where('gateway', 'razorpay')
            ->where('status', 'success')
            ->latest()
            ->first();

        if (! $transaction) {
            return ['success' => false, 'error' => 'No successful transaction found'];
        }

        $refund = $this->api->payment->fetch($transaction->transaction_id)->refund([
            'amount' => (int) round($amount * 100),
            'notes' => [
                'order_number' => $order->order_number,
                'reason' => 'Customer refund',
            ],
        ]);

        return [
            'success' => $refund->status === 'processed',
            'refund_id' => $refund->id,
            'gateway_response' => $refund->toArray(),
        ];
    }

    public function getName(): string
    {
        return 'razorpay';
    }
}
