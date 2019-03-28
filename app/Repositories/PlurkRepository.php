<?php

namespace App\Repositories;

use App\Models\Plurk;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PlurkRepository
 * @package App\Repositories
 * @version March 28, 2019, 3:30 am UTC
 *
 * @method Plurk findWithoutFail($id, $columns = ['*'])
 * @method Plurk find($id, $columns = ['*'])
 * @method Plurk first($columns = ['*'])
*/
class PlurkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'plurk_id',
        'user_id',
        'nick_name',
        'qualifier',
        'content',
        'posted'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Plurk::class;
    }
}
