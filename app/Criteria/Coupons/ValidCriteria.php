<?php
/*
 * File name: ValidCriteria.php
 * Last modified: 2021.02.19 at 02:00:41
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\Coupons;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ValidCriteriaCriteria.
 *
 * @package namespace App\Criteria\Coupons;
 */
class ValidCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $request;

    /**
     * ValidCriteria constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $code = trim($this->request->get('code', ''));
        $eServiceId = $this->request->get('e_service_id');
        $eProviderId = $this->request->get('e_provider_id');
        $categoriesId = $this->request->get('categories_id');

        $hasFilters = !empty($eServiceId) || !empty($eProviderId) || !empty($categoriesId);

        // Case-insensitive code matching, enabled check, and expiration check
        $model = $model->where(function ($q) use ($code) {
            $q->where('code', $code)
              ->orWhereRaw('LOWER(code) = ?', [strtolower($code)]);
        })
        ->where('enabled', '1')
        ->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', Carbon::now());
        });

        if ($hasFilters) {
            // A coupon is valid IF:
            // 1. It has NO discountables (global promo code valid for all services/providers), OR
            // 2. It has discountables matching the service, provider, or category filter
            $model = $model->where(function ($query) use ($eServiceId, $eProviderId, $categoriesId) {
                $query->whereDoesntHave('discountables')
                    ->orWhereHas('discountables', function ($q) use ($eServiceId, $eProviderId, $categoriesId) {
                        $q->where(function ($subQ) use ($eServiceId, $eProviderId, $categoriesId) {
                            if (!empty($eServiceId)) {
                                $subQ->orWhere(function ($q2) use ($eServiceId) {
                                    $q2->where('discountable_type', 'App\\Models\\EService')
                                       ->where('discountable_id', $eServiceId);
                                });
                            }
                            if (!empty($eProviderId)) {
                                $subQ->orWhere(function ($q2) use ($eProviderId) {
                                    $q2->where('discountable_type', 'App\\Models\\EProvider')
                                       ->where('discountable_id', $eProviderId);
                                });
                            }
                            if (!empty($categoriesId)) {
                                $catIds = is_array($categoriesId) ? $categoriesId : explode(',', $categoriesId);
                                $subQ->orWhere(function ($q2) use ($catIds) {
                                    $q2->where('discountable_type', 'App\\Models\\Category')
                                       ->whereIn('discountable_id', $catIds);
                                });
                            }
                        });
                    });
            });
        }

        return $model->select('coupons.*');
    }
}
