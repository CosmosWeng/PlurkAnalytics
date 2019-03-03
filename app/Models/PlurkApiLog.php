<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlurkApiLog
 * @package App\Models
 * @version March 3, 2019, 10:27 am UTC
 *
 * @property string|\Carbon\Carbon timestamp
 * @property integer code
 * @property string params
 * @property string method
 * @property string path
 * @property integer own_id
 * @property string own_type
 * @property string response
 */
class PlurkApiLog extends Model
{
    public $table      = 'plurk_api_logs';
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'timestamp',
        'code',
        'params',
        'method',
        'path',
        'own_id',
        'own_type',
        'response'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code'     => 'integer',
        'params'   => 'array',
        'method'   => 'string',
        'path'     => 'string',
        'own_id'   => 'integer',
        'own_type' => 'string',
        'response' => 'array'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
}
