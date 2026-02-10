<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $accessToken;
    protected string $phoneNumberId;

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token', '');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id', '');
        $this->apiUrl = 'https://graph.facebook.com/v21.0/' . $this->phoneNumberId;
    }

    /**
     * Send a template message via WhatsApp Cloud API.
     */
    public function sendTemplate(string $to, string $templateName, array $components = [], string $language = 'en'): bool
    {
        $to = $this->formatPhoneNumber($to);

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => ['code' => $language],
            ],
        ];

        if (! empty($components)) {
            $payload['template']['components'] = $components;
        }

        return $this->sendRequest('/messages', $payload);
    }

    /**
     * Send a free-form text message.
     */
    public function sendText(string $to, string $message): bool
    {
        $to = $this->formatPhoneNumber($to);

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'preview_url' => false,
                'body' => $message,
            ],
        ];

        return $this->sendRequest('/messages', $payload);
    }

    /**
     * Send an interactive message with buttons.
     */
    public function sendInteractive(string $to, string $body, array $buttons, ?string $header = null, ?string $footer = null): bool
    {
        $to = $this->formatPhoneNumber($to);

        $interactive = [
            'type' => 'button',
            'body' => ['text' => $body],
            'action' => [
                'buttons' => collect($buttons)->take(3)->map(fn ($btn, $i) => [
                    'type' => 'reply',
                    'reply' => [
                        'id' => $btn['id'] ?? 'btn_' . $i,
                        'title' => substr($btn['title'], 0, 20),
                    ],
                ])->values()->toArray(),
            ],
        ];

        if ($header) {
            $interactive['header'] = ['type' => 'text', 'text' => $header];
        }

        if ($footer) {
            $interactive['footer'] = ['text' => $footer];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'interactive',
            'interactive' => $interactive,
        ];

        return $this->sendRequest('/messages', $payload);
    }

    /**
     * Build template body parameters component.
     */
    public static function bodyParams(array $params): array
    {
        return [
            [
                'type' => 'body',
                'parameters' => collect($params)->map(fn ($value) => [
                    'type' => 'text',
                    'text' => (string) $value,
                ])->values()->toArray(),
            ],
        ];
    }

    /**
     * Send HTTP request to WhatsApp Cloud API.
     */
    protected function sendRequest(string $endpoint, array $payload): bool
    {
        if (empty($this->accessToken) || empty($this->phoneNumberId)) {
            Log::info('WhatsApp not configured, skipping message', [
                'endpoint' => $endpoint,
                'to' => $payload['to'] ?? 'unknown',
            ]);
            return false;
        }

        try {
            $response = Http::withToken($this->accessToken)
                ->timeout(30)
                ->post($this->apiUrl . $endpoint, $payload);

            if ($response->successful()) {
                Log::info('WhatsApp message sent', [
                    'to' => $payload['to'],
                    'message_id' => $response->json('messages.0.id'),
                ]);
                return true;
            }

            Log::error('WhatsApp API error', [
                'status' => $response->status(),
                'error' => $response->json('error'),
                'to' => $payload['to'],
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp API exception', [
                'message' => $e->getMessage(),
                'to' => $payload['to'] ?? 'unknown',
            ]);

            return false;
        }
    }

    /**
     * Format phone number to international format (India +91).
     */
    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) === 10) {
            return '91' . $phone;
        }

        if (str_starts_with($phone, '91') && strlen($phone) === 12) {
            return $phone;
        }

        if (str_starts_with($phone, '+91')) {
            return substr($phone, 1);
        }

        return $phone;
    }
}
