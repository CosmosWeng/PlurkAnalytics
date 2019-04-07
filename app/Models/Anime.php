<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Anime
 * @package App\Models
 * @version April 6, 2019, 1:28 pm UTC
 *
 * @property string serie_code
 * @property integer year
 * @property string type
 * @property string aired_text
 * @property string|\Carbon\Carbon aired_start
 * @property string|\Carbon\Carbon aired_end
 * @property integer episode
 * @property string comment
 */
class Anime extends Model
{
    // use SoftDeletes;

    public $table = 'animes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'serie_code' => 'string',
        'year'       => 'integer',
        'type'       => 'string',
        'aired_text' => 'string',
        'episode'    => 'integer',
        'comment'    => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id'         => 'required',
        'serie_code' => 'required',
        'year'       => 'required',
        'type'       => 'required',
        'aired_text' => 'required'
    ];

    public function infos()
    {
        return $this->hasMany('App\Models\AnimeInfo');
    }
}
