<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * @property int|string|null id
 * @property string title
 * @property string order
 * @property int|string user_id
 *
 * @property User owner
 *
 * @mixin Builder
 */
class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function __construct(array $attributes = [])
    {
        $this->user_id = Auth::id();
        $this->order = 0;
        parent::__construct($attributes);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
