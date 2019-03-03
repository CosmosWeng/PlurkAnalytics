<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlurkBotMissionLog
 * @package App\Models
 * @version March 3, 2019, 4:18 pm UTC
 *
 * @property integer plurk_id
 * @property string mission_code
 */
class PlurkBotMissionLog extends Model
{
    public $table      = 'plurk_bot_mission_logs';
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'plurk_id',
        'mission_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'plurk_id'     => 'integer',
        'mission_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
}
