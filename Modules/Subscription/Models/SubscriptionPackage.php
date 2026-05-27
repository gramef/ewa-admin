<?php
/*
 * File name: SubscriptionPackage.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SubscriptionPackage
 * @package Modules\Subscription\Models
 *
 * @property integer id
 * @property string name
 * @property string description
 * @property double price
 * @property integer duration_in_days
 * @property boolean is_free_trial
 * @property integer trial_duration_in_days
 * @property integer max_services
 * @property integer max_bookings_per_month
 * @property double commission_percentage
 * @property boolean featured_priority
 * @property boolean enabled
 * @property integer sort_order
 */
class SubscriptionPackage extends Model
{
    public $table = 'subscription_packages';

    public $fillable = [
        'name',
        'description',
        'price',
        'duration_in_days',
        'is_free_trial',
        'trial_duration_in_days',
        'max_services',
        'max_bookings_per_month',
        'commission_percentage',
        'featured_priority',
        'enabled',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'double',
        'duration_in_days' => 'integer',
        'is_free_trial' => 'boolean',
        'trial_duration_in_days' => 'integer',
        'max_services' => 'integer',
        'max_bookings_per_month' => 'integer',
        'commission_percentage' => 'double',
        'featured_priority' => 'boolean',
        'enabled' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:127',
        'price' => 'required|numeric|min:0',
        'duration_in_days' => 'required|integer|min:1',
        'commission_percentage' => 'numeric|min:0|max:100',
    ];

    /**
     * @return HasMany
     */
    public function eProviderSubscriptions(): HasMany
    {
        return $this->hasMany(EProviderSubscription::class, 'subscription_package_id');
    }

    /**
     * Get number of active subscribers for this package.
     */
    public function getActiveSubscribersCountAttribute(): int
    {
        return $this->eProviderSubscriptions()
            ->where('active', true)
            ->where('expires_at', '>', now())
            ->count();
    }
}
