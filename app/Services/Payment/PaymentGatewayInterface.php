<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Create a payment order/session with the gateway.
     * Returns gateway-specific data needed by the frontend.
     */
    public function createPaymentOrder(Order $order): array;

    /**
     * Verify a payment callback/webhook from the gateway.
     * Returns ['success' => bool, 'transaction_id' => string, 'gateway_response' => array].
     */
    public function verifyPayment(array $payload): array;

    /**
     * Process a refund for a transaction.
     */
    public function refund(Order $order, float $amount): array;

    /**
     * Get the gateway identifier name.
     */
    public function getName(): string;
}
