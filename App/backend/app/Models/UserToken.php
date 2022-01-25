<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;


/**
 * @property int|string|null id
 * @property string token
 * @property int|string|null user_id
 * @property string user_agent
 * @property int updated_at
 * @property int created_at
 *
 * @property User user
 *
 * @mixin Builder
 */
class UserToken extends Model
{
    use HasFactory;



    /*
    |--------------------------------------------------
    | Mass assignment
    |--------------------------------------------------
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'user_id',
        'user_agent',
    ];


    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * Which user this token refers to
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
