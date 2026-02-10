<?php

namespace App\Http\Controllers;

use App\Services\Notification\SmsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function __construct(
        protected SmsService $smsService,
    ) {}

    /**
     * Send OTP to a phone number.
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[6-9]\d{9}$/',
        ]);

        $this->smsService->sendOtp($request->phone);

        return response()->json([
            'message' => __('shop.otp_sent'),
            'success' => true,
        ]);
    }

    /**
     * Verify OTP for a phone number.
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[6-9]\d{9}$/',
            'otp' => 'required|string|size:6',
        ]);

        $verified = $this->smsService->verifyOtp($request->phone, $request->otp);

        if ($verified) {
            // Mark phone as verified for the authenticated user
            if (auth()->check()) {
                auth()->user()->update(['phone_verified_at' => now()]);
            }

            return response()->json([
                'message' => __('shop.otp_verified'),
                'success' => true,
            ]);
        }

        return response()->json([
            'message' => __('shop.otp_invalid'),
            'success' => false,
        ], 422);
    }
}
