<?php

namespace App\Repositories;

use App\Models\AnimeInfo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AnimeInfoRepository
 * @package App\Repositories
 * @version April 6, 2019, 1:29 pm UTC
 *
 * @method AnimeInfo findWithoutFail($id, $columns = ['*'])
 * @method AnimeInfo find($id, $columns = ['*'])
 * @method AnimeInfo first($columns = ['*'])
*/
class AnimeInfoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anime_id',
        'lang_id',
        'title',
        'synopsis',
        'producers',
        'director',
        'author'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AnimeInfo::class;
    }
}
