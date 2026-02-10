<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
    ) {}

    /**
     * Razorpay payment callback (POST from frontend after checkout.js completes).
     */
    public function razorpayCallback(Request $request, Order $order)
    {
        $validated = $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $success = $this->paymentService->confirm($order, $validated);

        if ($success) {
            return redirect()->route('order.success', $order)
                ->with('order_success', $order->order_number);
        }

        return redirect()->route('order.failed', $order)
            ->with('payment_error', __('shop.payment_failed_message'));
    }

    /**
     * Razorpay webhook handler (server-to-server).
     */
    public function razorpayWebhook(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret');

        if ($webhookSecret) {
            $signature = $request->header('X-Razorpay-Signature');
            $expectedSignature = hash_hmac('sha256', $request->getContent(), $webhookSecret);

            if (! hash_equals($expectedSignature, $signature ?? '')) {
                Log::warning('Razorpay webhook signature verification failed');
                return response('Invalid signature', 400);
            }
        }

        $payload = $request->all();
        $event = $payload['event'] ?? null;

        if ($event === 'payment.captured') {
            $paymentEntity = $payload['payload']['payment']['entity'] ?? [];
            $orderNumber = $paymentEntity['notes']['order_number'] ?? null;

            if ($orderNumber) {
                $order = Order::where('order_number', $orderNumber)->first();
                if ($order && $order->payment_status->value !== 'paid') {
                    $this->paymentService->confirm($order, [
                        'razorpay_payment_id' => $paymentEntity['id'],
                        'razorpay_order_id' => $paymentEntity['order_id'],
                        'razorpay_signature' => 'webhook_verified',
                    ]);
                }
            }
        }

        return response('OK', 200);
    }

    /**
     * PhonePe payment callback (redirect from PhonePe payment page).
     */
    public function phonePeCallback(Request $request, Order $order)
    {
        $transactionId = $order->transactions()
            ->where('gateway', 'phonepe')
            ->where('status', 'pending')
            ->latest()
            ->value('transaction_id');

        if (! $transactionId) {
            return redirect()->route('order.failed', $order)
                ->with('payment_error', __('shop.payment_failed_message'));
        }

        $success = $this->paymentService->confirm($order, [
            'merchantTransactionId' => $transactionId,
        ]);

        if ($success) {
            return redirect()->route('order.success', $order)
                ->with('order_success', $order->order_number);
        }

        return redirect()->route('order.failed', $order)
            ->with('payment_error', __('shop.payment_failed_message'));
    }

    /**
     * PhonePe webhook handler (server-to-server callback).
     */
    public function phonePeWebhook(Request $request)
    {
        $payload = $request->all();

        $response = $payload['response'] ?? null;
        if (! $response) {
            return response('Missing response', 400);
        }

        $decoded = json_decode(base64_decode($response), true);
        $merchantTransactionId = $decoded['data']['merchantTransactionId'] ?? null;

        if ($merchantTransactionId) {
            $transaction = \App\Models\Transaction::where('transaction_id', $merchantTransactionId)
                ->where('gateway', 'phonepe')
                ->first();

            if ($transaction && $transaction->status !== 'success') {
                $order = $transaction->order;
                $this->paymentService->confirm($order, [
                    'merchantTransactionId' => $merchantTransactionId,
                ]);
            }
        }

        return response('OK', 200);
    }

    /**
     * Order success page.
     */
    public function orderSuccess(Order $order)
    {
        // Only allow viewing if user owns this order (or is guest)
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.order-success', compact('order'));
    }

    /**
     * Order failed page.
     */
    public function orderFailed(Order $order)
    {
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.order-failed', compact('order'));
    }
}
