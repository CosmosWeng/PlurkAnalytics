<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlurkBotMission
 * @package App\Models
 * @version March 12, 2019, 6:14 am UTC
 *
 * @property string name
 * @property string type
 * @property string lang
 * @property string code
 * @property string keyword
 * @property integer sorting
 */
class PlurkBotMission extends Model
{
    // use SoftDeletes;

    public $table      = 'plurk_bot_missions';
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'type',
        'lang',
        'code',
        'keyword',
        'parent'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'name'    => 'string',
        'type'    => 'string',
        'lang'    => 'string',
        'code'    => 'string',
        'keyword' => 'string',
        'parent'  => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];
}
