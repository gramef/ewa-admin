<?php
/*
 * File name: EProvidersOfUserCriteria.php
 * Last modified: 2022.04.13 at 13:31:34
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Criteria\Users;

use App\Models\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EProvidersOfUserCriteria.
 *
 * @package namespace App\Criteria\EProviders;
 */
class UserOfEProviderCriteria implements CriteriaInterface
{

    /**
     * @var User
     */
    private $eProviderId;

    /**
     * EProvidersOfUserCriteria constructor.
     */
    public function __construct($eProviderId)
    {
        $this->eProviderId = $eProviderId;
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
        } elseif (auth()->user()->hasAnyRole(['provider', 'customer'])) {
            return $model
                ->join('e_provider_users', 'e_provider_users.e_provider_id', '=', 'e_provider_payouts.e_provider_id')
                ->join('e_provider_users', 'e_provider_users.user_id', '=', 'users.id')
                ->where('e_provider_users.e_provider_id', $this->eProviderId)
                ->select('users.*');
        } else {
            return $model;
        }
    }
}
