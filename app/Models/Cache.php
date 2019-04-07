<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cache
 * @package App\Models
 * @version April 5, 2019, 6:39 pm UTC
 *
 * @property integer timestamp
 * @property string code
 * @property string json
 * @property string comment
 */
class Cache extends Model
{
    // use SoftDeletes;

    public $table      = 'caches';
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'timestamp',
        'code',
        'json',
        'comment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'timestamp' => 'integer',
        'code'      => 'string',
        'json'      => 'array',
        'comment'   => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id'        => 'required',
        'timestamp' => 'required',
        'code'      => 'required',
        'json'      => 'required',
        // 'comment'   => 'required'
    ];
}
