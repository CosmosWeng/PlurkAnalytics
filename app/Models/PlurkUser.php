<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlurkUser
 * @package App\Models
 * @version February 23, 2019, 9:20 am UTC
 *
 * @property integer user_id
 * @property integer uuid
 * @property string nick_name
 * @property string display_name
 * @property string privacy
 * @property string token
 * @property string secret
 */
class PlurkUser extends Model
{
    use SoftDeletes;

    public $table         = 'plurk_users';
    public $incrementing  = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates      = ['deleted_at'];
    protected $primaryKey = 'uuid';

    public $fillable = [
        'user_id',
        'uuid',
        'nick_name',
        'display_name',
        'privacy',
        'token',
        'secret'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'           => 'integer',
        'user_id'      => 'integer',
        'uuid'         => 'integer',
        'nick_name'    => 'string',
        'display_name' => 'string',
        'privacy'      => 'string',
        'token'        => 'string',
        'secret'       => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
