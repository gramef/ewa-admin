<?php
/**
 * File name: EProviderLocationRepository.php
 * Last modified: 2021.01.03 at 15:29:51
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Repositories;

use App\Models\Faq;
use App\Models\EProviderLocation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FaqRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:39 pm UTC
 *
 * @method EProviderLocation findWithoutFail($id, $columns = ['*'])
 * @method EProviderLocation find($id, $columns = ['*'])
 * @method EProviderLocation first($columns = ['*'])
 */
class EProviderLocationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'booking_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EProviderLocation::class;
    }
}
