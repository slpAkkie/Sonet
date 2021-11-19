<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @property int|string|null id
 * @property string title
 * @property int|string note_id
 * @property string path
 * @property int created_at
 * @property int updated_at
 *
 * @property Note note
 *
 * @mixin Builder
 */
class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path',
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'note_id', 'id');
    }
}
