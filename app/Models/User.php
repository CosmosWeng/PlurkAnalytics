<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version December 24, 2018, 7:36 am UTC
 *
 * @property string privacy
 * @property string token
 * @property string secret
 */
class User extends Model
{
    // use SoftDeletes;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'name'          => 'string',
        'email'         => 'string',
        'password'      => 'string',
        'api_token'     => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public static function getUserByToken(string $token)
    {
        return self::where('api_token', $token)->first();
    }

    public function plurkUser()
    {
        return $this->hasOne('App\Models\PlurkUser');
    }
}
