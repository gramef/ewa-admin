<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserReferral extends Model
{
    public $table = 'user_referrals';

    public $fillable = [
        'referrer_id',
        'referee_id',
        'referral_package_id',
        'referral_code',
        'status',
        'qualifying_booking_id',
        'referrer_coupon_id',
        'referee_coupon_id',
        'rewarded_at',
    ];

    protected $casts = [
        'rewarded_at' => 'datetime',
    ];

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    public function package()
    {
        return $this->belongsTo(ReferralPackage::class, 'referral_package_id');
    }

    public function qualifyingBooking()
    {
        return $this->belongsTo(Booking::class, 'qualifying_booking_id');
    }

    public function referrerCoupon()
    {
        return $this->belongsTo(Coupon::class, 'referrer_coupon_id');
    }

    public function refereeCoupon()
    {
        return $this->belongsTo(Coupon::class, 'referee_coupon_id');
    }

    /**
     * Check if a completed booking qualifies the referral for reward.
     */
    public static function checkAndAwardQualification(Booking $booking): ?self
    {
        if (empty($booking->user_id)) {
            return null;
        }

        $referral = self::with('package')
            ->where('referee_id', $booking->user_id)
            ->where('status', 'pending')
            ->first();

        if (!$referral || !$referral->package) {
            return null;
        }

        $package = $referral->package;

        // Verify min spend
        $subtotal = (float) ($booking->booking_at ? $booking->getSubtotal() : ($booking->e_service ? $booking->e_service->price : 0));
        if ($package->min_booking_amount > 0 && $subtotal < $package->min_booking_amount) {
            return null;
        }

        // Verify completed bookings count
        $completedCount = Booking::where('user_id', $booking->user_id)
            ->where('booking_status_id', 6)
            ->count();

        if ($completedCount < ($package->required_completed_bookings ?? 1)) {
            return null;
        }

        // Create coupon for Referrer
        $referrerCoupon = null;
        try {
            $couponCode = 'REF-' . strtoupper(Str::random(6));
            $discountType = ($package->reward_type === 'percentage_discount') ? 'percent' : 'fixed';

            $referrerCoupon = Coupon::create([
                'code' => $couponCode,
                'discount' => $package->referrer_reward_value,
                'discount_type' => $discountType,
                'description' => "Referral reward from friend's first booking",
                'expires_at' => now()->addDays(60),
                'enabled' => true,
            ]);
        } catch (\Exception $e) {
            \Log::warning('Referral coupon generation failed: ' . $e->getMessage());
        }

        $referral->status = 'rewarded';
        $referral->qualifying_booking_id = $booking->id;
        $referral->referrer_coupon_id = $referrerCoupon ? $referrerCoupon->id : null;
        $referral->rewarded_at = now();
        $referral->save();

        \Log::info("Referral #{$referral->id} rewarded! Referrer #{$referral->referrer_id} awarded coupon: " . ($referrerCoupon->code ?? 'N/A'));

        return $referral;
    }
}
