<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $provider;

    public function __construct()
    {
        $this->provider = config('services.sms.provider', 'log');
    }

    /**
     * Send an SMS message.
     */
    public function send(string $to, string $message): bool
    {
        $to = $this->formatPhoneNumber($to);

        return match ($this->provider) {
            'msg91' => $this->sendViaMsg91($to, $message),
            'twilio' => $this->sendViaTwilio($to, $message),
            default => $this->logMessage($to, $message),
        };
    }

    /**
     * Generate and send OTP to a phone number.
     */
    public function sendOtp(string $phone): string
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('otp:' . $phone, $otp, now()->addMinutes(10));

        $message = __('shop.otp_message', ['otp' => $otp, 'app' => config('app.name')]);
        $this->send($phone, $message);

        return $otp;
    }

    /**
     * Verify an OTP for a phone number.
     */
    public function verifyOtp(string $phone, string $otp): bool
    {
        $phone = $this->formatPhoneNumber($phone);
        $storedOtp = Cache::get('otp:' . $phone);

        if ($storedOtp && hash_equals($storedOtp, $otp)) {
            Cache::forget('otp:' . $phone);
            return true;
        }

        return false;
    }

    /**
     * Send SMS via MSG91.
     */
    protected function sendViaMsg91(string $to, string $message): bool
    {
        try {
            $response = Http::withHeaders([
                'authkey' => config('services.sms.msg91.auth_key'),
                'Content-Type' => 'application/json',
            ])->post('https://control.msg91.com/api/v5/flow/', [
                'template_id' => config('services.sms.msg91.template_id'),
                'short_url' => '0',
                'recipients' => [
                    [
                        'mobiles' => $to,
                        'message' => $message,
                    ],
                ],
            ]);

            if ($response->successful()) {
                Log::info('MSG91 SMS sent', ['to' => $to]);
                return true;
            }

            Log::error('MSG91 SMS failed', [
                'to' => $to,
                'response' => $response->json(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('MSG91 SMS exception', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send SMS via Twilio.
     */
    protected function sendViaTwilio(string $to, string $message): bool
    {
        try {
            $response = Http::withBasicAuth(
                config('services.sms.twilio.sid'),
                config('services.sms.twilio.token'),
            )->asForm()->post(
                'https://api.twilio.com/2010-04-01/Accounts/' . config('services.sms.twilio.sid') . '/Messages.json',
                [
                    'To' => '+' . $to,
                    'From' => config('services.sms.twilio.from'),
                    'Body' => $message,
                ]
            );

            if ($response->successful()) {
                Log::info('Twilio SMS sent', ['to' => $to, 'sid' => $response->json('sid')]);
                return true;
            }

            Log::error('Twilio SMS failed', [
                'to' => $to,
                'response' => $response->json(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Twilio SMS exception', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Fallback: log the message instead of sending.
     */
    protected function logMessage(string $to, string $message): bool
    {
        Log::info('SMS (log provider)', ['to' => $to, 'message' => $message]);
        return true;
    }

    /**
     * Format phone number.
     */
    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) === 10) {
            return '91' . $phone;
        }

        return $phone;
    }
}
