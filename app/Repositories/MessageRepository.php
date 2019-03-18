<?php

namespace App\Repositories;

use App\Models\Message;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MessageRepository
 * @package App\Repositories
 * @version March 18, 2019, 6:38 am UTC
 *
 * @method Message findWithoutFail($id, $columns = ['*'])
 * @method Message find($id, $columns = ['*'])
 * @method Message first($columns = ['*'])
*/
class MessageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'parent_id',
        'title',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Message::class;
    }
}
