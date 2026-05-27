<?php
/*
 * File name: EProviderSubscription.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Models;

use App\Models\EProvider;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class EProviderSubscription
 * @package Modules\Subscription\Models
 *
 * @property integer id
 * @property integer e_provider_id
 * @property integer subscription_package_id
 * @property string starts_at
 * @property string expires_at
 * @property boolean active
 * @property boolean is_trial
 * @property integer payment_id
 * @property string notes
 * @property bool is_expired
 * @property int days_remaining
 */
class EProviderSubscription extends Model
{
    public $table = 'e_provider_subscriptions';

    public $fillable = [
        'e_provider_id',
        'subscription_package_id',
        'starts_at',
        'expires_at',
        'active',
        'is_trial',
        'payment_id',
        'notes',
    ];

    protected $casts = [
        'e_provider_id' => 'integer',
        'subscription_package_id' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'active' => 'boolean',
        'is_trial' => 'boolean',
        'payment_id' => 'integer',
    ];

    protected $appends = [
        'is_expired',
        'days_remaining',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function eProvider(): BelongsTo
    {
        return $this->belongsTo(EProvider::class, 'e_provider_id');
    }

    /**
     * @return BelongsTo
     */
    public function subscriptionPackage(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id');
    }

    /**
     * Check if the subscription has expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get the number of days remaining on the subscription.
     */
    public function getDaysRemainingAttribute(): int
    {
        if (!$this->expires_at || $this->expires_at->isPast()) {
            return 0;
        }
        return (int) now()->diffInDays($this->expires_at, false);
    }

    /**
     * Scope to only active, non-expired subscriptions.
     */
    public function scopeValid($query)
    {
        return $query->where('active', true)
            ->where('expires_at', '>', now())
            ->where('starts_at', '<=', now());
    }
}
