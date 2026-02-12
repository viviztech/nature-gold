<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Str;

class ReferralService
{
    public function handleReferralVisit(string $code): bool
    {
        $referrer = User::where('referral_code', $code)->first();

        if (! $referrer) {
            return false;
        }

        cookie()->queue('referral_code', $code, 60 * 24 * 30); // 30 days

        return true;
    }

    public function processReferral(User $newUser): ?Referral
    {
        $code = request()->cookie('referral_code');

        if (! $code) {
            return null;
        }

        $referrer = User::where('referral_code', $code)->first();

        if (! $referrer || $referrer->id === $newUser->id) {
            return null;
        }

        // Check if this referral already exists
        if (Referral::where('referrer_id', $referrer->id)->where('referred_id', $newUser->id)->exists()) {
            return null;
        }

        $newUser->update(['referred_by' => $referrer->id]);

        // Create reward coupon for referrer
        $coupon = $this->createRewardCoupon($referrer);

        // Create the referral record
        $referral = Referral::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $newUser->id,
            'coupon_id' => $coupon->id,
            'reward_amount' => 50.00,
            'is_rewarded' => true,
        ]);

        // Clear the cookie
        cookie()->queue(cookie()->forget('referral_code'));

        return $referral;
    }

    protected function createRewardCoupon(User $user): Coupon
    {
        $code = 'REF' . strtoupper(Str::random(7));

        return Coupon::create([
            'code' => $code,
            'type' => 'fixed',
            'value' => 50.00,
            'min_order' => 299,
            'usage_limit' => 1,
            'per_user_limit' => 1,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(90),
        ]);
    }

    public function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    public function getUserStats(User $user): array
    {
        $referrals = Referral::where('referrer_id', $user->id)
            ->with('referred:id,name,created_at')
            ->latest()
            ->get();

        return [
            'referrals' => $referrals,
            'total_count' => $referrals->count(),
            'total_rewards' => $referrals->where('is_rewarded', true)->sum('reward_amount'),
        ];
    }
}
