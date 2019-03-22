<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Route
 * @package App\Models
 * @version March 22, 2019, 8:22 am UTC
 *
 * @property integer parent_id
 * @property string type
 * @property string name
 * @property string method
 * @property string uri
 * @property string redirect
 * @property string meta
 */
class Route extends Model
{
    // use SoftDeletes;

    public $table = 'routes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'parent_id',
        'type',
        'name',
        'method',
        'uri',
        'redirect',
        'meta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'parent_id' => 'integer',
        'type'      => 'string',
        'name'      => 'string',
        'method'    => 'string',
        'uri'       => 'string',
        'redirect'  => 'string',
        'meta'      => 'array'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'id'         => 'required',
        // 'parent_id'  => 'required',
        // 'type'       => 'required',
        // 'name'       => 'required',
        // 'method'     => 'required',
        // 'uri'        => 'required',
        // 'updated_at' => 'required',
        // 'created_at' => 'required'
    ];
}
