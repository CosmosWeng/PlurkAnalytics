<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Message
 * @package App\Models
 * @version March 18, 2019, 6:38 am UTC
 *
 * @property integer user_id
 * @property integer parent_id
 * @property string title
 * @property string content
 */
class Message extends Model
{
    use SoftDeletes;

    public $table = 'messages';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'parent_id',
        'title',
        'content',
        'is_reply',
        'is_public'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'user_id'     => 'integer',
        'parent_id'   => 'integer',
        'title'       => 'string',
        'content'     => 'string',
        'is_reply'    => 'integer',
        'is_public'   => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function children()
    {
        return $this->hasMany('App\Models\Message', 'parent_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id');
    }
}
