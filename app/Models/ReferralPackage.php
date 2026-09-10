<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralPackage extends Model
{
    public $table = 'referral_packages';

    public $fillable = [
        'name',
        'target_role',
        'reward_type',
        'referrer_reward_value',
        'referee_reward_value',
        'min_booking_amount',
        'required_completed_bookings',
        'description',
        'enabled',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'referrer_reward_value' => 'double',
        'referee_reward_value' => 'double',
        'min_booking_amount' => 'double',
        'required_completed_bookings' => 'integer',
        'enabled' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static array $rules = [
        'name' => 'required|string|max:191',
        'target_role' => 'required|in:client,vendor,all',
        'reward_type' => 'required|in:fixed_discount,percentage_discount,wallet_credit,commission_reduction',
        'referrer_reward_value' => 'required|numeric|min:0',
        'referee_reward_value' => 'required|numeric|min:0',
        'min_booking_amount' => 'nullable|numeric|min:0',
        'required_completed_bookings' => 'nullable|integer|min:1',
        'description' => 'nullable|string',
        'enabled' => 'nullable|boolean',
    ];

    public function referrals()
    {
        return $this->hasMany(UserReferral::class, 'referral_package_id');
    }

    public function scopeActive($query, $role = null)
    {
        $query->where('enabled', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });

        if ($role) {
            $query->where(function ($q) use ($role) {
                $q->where('target_role', $role)->orWhere('target_role', 'all');
            });
        }

        return $query;
    }

    /**
     * Retrieve the current default active package for a role.
     */
    public static function getActivePackage(string $role = 'client'): ?self
    {
        return self::active($role)->latest()->first();
    }
}
