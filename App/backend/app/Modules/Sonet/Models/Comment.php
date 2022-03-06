<?php

namespace App\Modules\Sonet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @property int|string|null id
 * @property int|string user_id
 * @property int|string note_id
 * @property string body
 * @property int created_at
 * @property int updated_at
 *
 * @property User author
 * @property Note note
 *
 * @mixin Builder
 */
class Comment extends Model
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
        'body',
        'user_id',
    ];


    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * Comment author
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Which note this comment refers to
     *
     * @return BelongsTo
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'note_id', 'id');
    }
}
