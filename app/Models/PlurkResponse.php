<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlurkResponse
 * @package App\Models
 * @version March 3, 2019, 4:06 pm UTC
 *
 * @property integer plurk_id
 * @property integer user_id
 * @property integer response_id
 * @property string qualifier
 * @property string content
 * @property string|\Carbon\Carbon posted
 */
class PlurkResponse extends Model
{
    public $table      = 'plurk_responses';
    public $timestamps = false;

    const CREATED_AT = 'posted';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'plurk_id',
        'user_id',
        'response_id',
        'qualifier',
        'content',
        'content_raw',
        'posted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'plurk_id'    => 'integer',
        'user_id'     => 'integer',
        'response_id' => 'integer',
        'qualifier'   => 'string',
        'content'     => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
}
