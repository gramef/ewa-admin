<?php
/*
 * File name: PaidBookingsCriteria.php
 * Last modified: 2021.02.22 at 14:23:36
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\Bookings;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PaidBookingsCriteria.
 *
 * @package namespace App\Criteria\Bookings;
 */
class PaidBookingsCriteria implements CriteriaInterface
{
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
        return $model->where(function ($query) {
            $query->whereHas('payment', function ($q) {
                $q->where('payment_status_id', 2);
            })->orWhere('booking_status_id', 5);
        })
        ->groupBy('bookings.id')
        ->select('bookings.*');
    }
}
