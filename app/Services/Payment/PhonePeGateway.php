<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PhonePeGateway implements PaymentGatewayInterface
{
    protected string $merchantId;

    protected string $saltKey;

    protected int $saltIndex;

    protected string $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('services.phonepe.merchant_id');
        $this->saltKey = config('services.phonepe.salt_key');
        $this->saltIndex = (int) config('services.phonepe.salt_index', 1);
        $this->baseUrl = config('services.phonepe.env') === 'production'
            ? 'https://api.phonepe.com/apis/hermes'
            : 'https://api-preprod.phonepe.com/apis/pg-sandbox';
    }

    public function createPaymentOrder(Order $order): array
    {
        $transactionId = 'NG_' . Str::upper(Str::random(20));

        $payload = [
            'merchantId' => $this->merchantId,
            'merchantTransactionId' => $transactionId,
            'merchantUserId' => 'MUID_' . ($order->user_id ?? session()->getId()),
            'amount' => (int) round($order->total * 100), // Amount in paise
            'redirectUrl' => route('payment.phonepe.callback', ['order' => $order->id]),
            'redirectMode' => 'POST',
            'callbackUrl' => route('payment.phonepe.webhook'),
            'paymentInstrument' => [
                'type' => 'PAY_PAGE',
            ],
        ];

        $encodedPayload = base64_encode(json_encode($payload));
        $checksum = hash('sha256', $encodedPayload . '/pg/v1/pay' . $this->saltKey) . '###' . $this->saltIndex;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-VERIFY' => $checksum,
        ])->post("{$this->baseUrl}/pg/v1/pay", [
            'request' => $encodedPayload,
        ]);

        $data = $response->json();

        if ($data['success'] ?? false) {
            return [
                'success' => true,
                'transaction_id' => $transactionId,
                'redirect_url' => $data['data']['instrumentResponse']['redirectInfo']['url'] ?? null,
                'gateway_response' => $data,
            ];
        }

        return [
            'success' => false,
            'error' => $data['message'] ?? 'PhonePe payment initiation failed',
            'gateway_response' => $data,
        ];
    }

    public function verifyPayment(array $payload): array
    {
        $merchantTransactionId = $payload['merchantTransactionId']
            ?? $payload['transactionId']
            ?? null;

        if (! $merchantTransactionId) {
            return ['success' => false, 'gateway_response' => ['error' => 'Missing transaction ID']];
        }

        $checksum = hash('sha256', "/pg/v1/status/{$this->merchantId}/{$merchantTransactionId}" . $this->saltKey) . '###' . $this->saltIndex;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-VERIFY' => $checksum,
            'X-MERCHANT-ID' => $this->merchantId,
        ])->get("{$this->baseUrl}/pg/v1/status/{$this->merchantId}/{$merchantTransactionId}");

        $data = $response->json();
        $success = ($data['success'] ?? false) && ($data['code'] ?? '') === 'PAYMENT_SUCCESS';

        return [
            'success' => $success,
            'transaction_id' => $merchantTransactionId,
            'gateway_response' => $data,
        ];
    }

    public function refund(Order $order, float $amount): array
    {
        $transaction = $order->transactions()
            ->where('gateway', 'phonepe')
            ->where('status', 'success')
            ->latest()
            ->first();

        if (! $transaction) {
            return ['success' => false, 'error' => 'No successful transaction found'];
        }

        $refundId = 'NGREF_' . Str::upper(Str::random(20));

        $payload = [
            'merchantId' => $this->merchantId,
            'merchantUserId' => 'MUID_' . ($order->user_id ?? 'guest'),
            'originalTransactionId' => $transaction->transaction_id,
            'merchantTransactionId' => $refundId,
            'amount' => (int) round($amount * 100),
            'callbackUrl' => route('payment.phonepe.webhook'),
        ];

        $encodedPayload = base64_encode(json_encode($payload));
        $checksum = hash('sha256', $encodedPayload . '/pg/v1/refund' . $this->saltKey) . '###' . $this->saltIndex;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-VERIFY' => $checksum,
        ])->post("{$this->baseUrl}/pg/v1/refund", [
            'request' => $encodedPayload,
        ]);

        $data = $response->json();

        return [
            'success' => $data['success'] ?? false,
            'refund_id' => $refundId,
            'gateway_response' => $data,
        ];
    }

    public function getName(): string
    {
        return 'phonepe';
    }
}
