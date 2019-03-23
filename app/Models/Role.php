<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package App\Models
 * @version March 22, 2019, 8:55 am UTC
 *
 * @property string name
 * @property string slug
 */
class Role extends Model
{
    // use SoftDeletes;

    public $table = 'roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates  = ['deleted_at'];
    protected $hidden = ['pivot'];

    public $fillable = [
        'name',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'   => 'integer',
        'name' => 'string',
        'slug' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'id'         => 'required',
        // 'name'       => 'required',
        // 'slug'       => 'required',
        // 'updated_at' => 'required',
        // 'created_at' => 'required'
    ];
}
