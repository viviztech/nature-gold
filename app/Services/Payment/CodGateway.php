<?php

namespace App\Services\Payment;

use App\Models\Order;

class CodGateway implements PaymentGatewayInterface
{
    public function createPaymentOrder(Order $order): array
    {
        return [
            'success' => true,
            'payment_method' => 'cod',
            'message' => 'Cash on Delivery order placed successfully',
        ];
    }

    public function verifyPayment(array $payload): array
    {
        // COD payments are verified on delivery, not online
        return [
            'success' => true,
            'transaction_id' => 'COD_' . ($payload['order_number'] ?? uniqid()),
            'gateway_response' => ['method' => 'cod', 'status' => 'pending_delivery'],
        ];
    }

    public function refund(Order $order, float $amount): array
    {
        // COD refunds are handled manually
        return [
            'success' => true,
            'refund_id' => 'COD_REFUND_' . uniqid(),
            'gateway_response' => ['method' => 'cod', 'note' => 'Manual refund required'],
        ];
    }

    public function getName(): string
    {
        return 'cod';
    }
}
