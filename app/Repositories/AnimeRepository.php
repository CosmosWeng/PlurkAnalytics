<?php

namespace App\Repositories;

use App\Models\Anime;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AnimeRepository
 * @package App\Repositories
 * @version April 6, 2019, 1:28 pm UTC
 *
 * @method Anime findWithoutFail($id, $columns = ['*'])
 * @method Anime find($id, $columns = ['*'])
 * @method Anime first($columns = ['*'])
*/
class AnimeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serie_code',
        'year',
        'type',
        'aired_text',
        'aired_start',
        'aired_end',
        'episode',
        'comment'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Anime::class;
    }
}
