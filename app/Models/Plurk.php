<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Plurk
 * @package App\Models
 * @version March 3, 2019, 3:58 pm UTC
 *
 * @property integer plurk_id
 * @property integer user_id
 * @property string qualifier
 * @property string content
 * @property string|\Carbon\Carbon posted
 */
class Plurk extends Model
{
    public $table      = 'plurks';
    public $timestamps = false;

    const CREATED_AT = 'posted';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'plurk_id',
        'user_id',
        'nick_name',
        'qualifier',
        'content',
        'posted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'plurk_id'  => 'integer',
        'user_id'   => 'integer',
        'nick_name' => 'string',
        'qualifier' => 'string',
        'content'   => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
}
