<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\ReferralPackage;
use App\Models\User;
use App\Models\UserReferral;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralAPIController extends Controller
{
    /**
     * Get the authenticated user's referral code, active package rules, and stats.
     * GET /api/referrals/my-code
     */
    public function myCode(Request $request): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $code = $user->getOrCreateReferralCode();
        $isVendor = method_exists($user, 'hasRole') && $user->hasRole('provider');
        $targetRole = $isVendor ? 'vendor' : 'client';

        $activePackage = ReferralPackage::getActivePackage($targetRole);

        $referrals = UserReferral::with(['referee:id,name,phone_number,created_at', 'referrerCoupon'])
            ->where('referrer_id', $user->id)
            ->latest()
            ->get();

        $rewardedCount = $referrals->where('status', 'rewarded')->count();
        $pendingCount = $referrals->where('status', 'pending')->count();

        $data = [
            'referral_code' => $code,
            'share_url' => "https://ewaofficialapp.com/?ref={$code}",
            'package' => $activePackage ? [
                'name' => $activePackage->name,
                'reward_type' => $activePackage->reward_type,
                'referrer_reward_value' => (float)$activePackage->referrer_reward_value,
                'referee_reward_value' => (float)$activePackage->referee_reward_value,
                'min_booking_amount' => (float)$activePackage->min_booking_amount,
                'description' => $activePackage->description,
            ] : null,
            'stats' => [
                'total_invited' => $referrals->count(),
                'rewarded_count' => $rewardedCount,
                'pending_count' => $pendingCount,
                'total_earned_amount' => $rewardedCount * ($activePackage ? (float)$activePackage->referrer_reward_value : 10.0),
            ],
            'referrals' => $referrals->map(function ($r) {
                return [
                    'id' => $r->id,
                    'referee_name' => $r->referee->name ?? 'Friend',
                    'status' => $r->status,
                    'reward_coupon' => $r->referrerCoupon->code ?? null,
                    'date' => $r->created_at->toIso8601String(),
                ];
            }),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Referral info retrieved successfully',
        ]);
    }

    /**
     * Apply a friend's referral code.
     * POST /api/referrals/apply
     */
    public function apply(Request $request): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'referral_code' => 'required|string|max:32',
        ]);

        $code = strtoupper(trim($request->referral_code));

        // Check if user has already used a referral code
        if (UserReferral::where('referee_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied a referral code.',
            ], 422);
        }

        // Find referrer
        $referrer = User::where('referral_code', $code)->first();
        if (!$referrer) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid referral code. Please check and try again.',
            ], 404);
        }

        if ((int)$referrer->id === (int)$user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot use your own referral code.',
            ], 422);
        }

        $isVendor = method_exists($user, 'hasRole') && $user->hasRole('provider');
        $targetRole = $isVendor ? 'vendor' : 'client';
        $package = ReferralPackage::getActivePackage($targetRole);

        // Generate welcome coupon for the new user if package defines referee reward
        $refereeCoupon = null;
        if ($package && $package->referee_reward_value > 0) {
            try {
                $couponCode = 'WELCOME-' . strtoupper(Str::random(6));
                $discountType = ($package->reward_type === 'percentage_discount') ? 'percent' : 'fixed';

                $refereeCoupon = Coupon::create([
                    'code' => $couponCode,
                    'discount' => $package->referee_reward_value,
                    'discount_type' => $discountType,
                    'description' => "Welcome discount from friend's referral ({$code})",
                    'expires_at' => now()->addDays(30),
                    'enabled' => true,
                ]);
            } catch (\Exception $e) {
                \Log::warning('Referee coupon creation error: ' . $e->getMessage());
            }
        }

        $referral = UserReferral::create([
            'referrer_id' => $referrer->id,
            'referee_id' => $user->id,
            'referral_package_id' => $package ? $package->id : null,
            'referral_code' => $code,
            'status' => 'pending',
            'referee_coupon_id' => $refereeCoupon ? $refereeCoupon->id : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Referral code applied successfully! Your welcome discount has been unlocked.',
            'data' => [
                'coupon_code' => $refereeCoupon ? $refereeCoupon->code : null,
                'discount' => $package ? (float)$package->referee_reward_value : 0,
                'referrer_name' => $referrer->name,
            ],
        ]);
    }
}
