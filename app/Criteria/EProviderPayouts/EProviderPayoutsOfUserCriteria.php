<?php
/*
 * File name: EProviderPayoutsOfUserCriteria.php
 * Last modified: 2021.05.07 at 19:12:31
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Criteria\EProviderPayouts;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EProviderPayoutsOfUserCriteria.
 *
 * @package namespace App\Criteria\Bookings;
 */
class EProviderPayoutsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var User
     */
    private $userId;

    /**
     * EProviderPayoutsOfUserCriteria constructor.
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
        Log::info("EProviderPayoutsOfUserCriteria");
        if (auth()->user()->hasRole('admin')) {
            return $model;
        } else if (auth()->user()->hasRole('provider')) {
            return $model->join("e_provider_users", "e_provider_users.e_provider_id", "=", 'e_provider_payouts.e_provider_id')
                ->select('e_provider_payouts.*')
                ->where('e_provider_users.user_id', $this->userId);


        } else {
            return $model;
        }
    }
}
