<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AnimeInfo
 * @package App\Models
 * @version April 6, 2019, 1:29 pm UTC
 *
 * @property integer anime_id
 * @property integer lang_id
 * @property string title
 * @property string synopsis
 * @property string producers
 * @property string director
 * @property string author
 */
class AnimeInfo extends Model
{
    public $table      = 'anime_infos';
    // public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'anime_id',
        'lang_id',
        'title',
        'synopsis',
        'producers',
        'director',
        'author',
        'wiki_source'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'anime_id'    => 'integer',
        'lang_id'     => 'integer',
        'title'       => 'string',
        'synopsis'    => 'string',
        'producers'   => 'string',
        'director'    => 'string',
        'author'      => 'string',
        'wiki_source' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id'         => 'required',
        'anime_id'   => 'required',
        'lang_id'    => 'required',
        'title'      => 'required',
        'synopsis'   => 'required',
        'updated_at' => 'required',
        'created_at' => 'required'
    ];
}
