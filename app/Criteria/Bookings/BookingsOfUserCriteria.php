<?php
/*
 * File name: BookingsOfUserCriteria.php
 * Last modified: 2021.05.07 at 19:12:31
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\Bookings;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BookingsOfUserCriteria.
 *
 * @package namespace App\Criteria\Bookings;
 */
class BookingsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var User
     */
    private $userId;

    /**
     * BookingsOfUserCriteria constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
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
        if (auth()->user()->hasRole('admin')) {
            return $model;
        } else if (auth()->user()->hasRole('provider')) {
            // Fetch provider IDs associated with this user
            $providerIds = DB::table('e_provider_users')
                ->where('user_id', $this->userId)
                ->pluck('e_provider_id')
                ->toArray();

            return $model->where(function ($query) use ($providerIds) {
                $query->where('bookings.user_id', $this->userId);
                if (!empty($providerIds)) {
                    foreach ($providerIds as $pId) {
                        $query->orWhereRaw("CAST(json_extract(e_provider, '$.id') AS UNSIGNED) = ?", [(int)$pId]);
                    }
                }
            })
            ->groupBy('bookings.id')
            ->select('bookings.*');

        } else if (auth()->user()->hasRole('customer')) {
            return $model->where('bookings.user_id', $this->userId)
                ->select('bookings.*')
                ->groupBy('bookings.id');
        } else {
            return $model;
        }
    }
}
