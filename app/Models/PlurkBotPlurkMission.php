<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlurkBotPlurkMission
 * @package App\Models
 * @version March 12, 2019, 6:44 am UTC
 *
 * @property integer plurk_id
 * @property string nick_name
 * @property integer mission_id
 * @property integer status
 * @property string response
 */
class PlurkBotPlurkMission extends Model
{
    // use SoftDeletes;

    public $table      = 'plurk_bot_plurk_mission';
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'plurk_id',
        'nick_name',
        'mission_id',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'plurk_id'   => 'integer',
        'nick_name'  => 'string',
        'mission_id' => 'integer',
        'status'     => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function plurk()
    {
        return $this->hasOne('App\Models\Plurk', 'plurk_id', 'plurk_id');
    }

    public function mission()
    {
        return $this->hasOne('App\Models\PlurkBotMission', 'id', 'mission_id');
    }
}
