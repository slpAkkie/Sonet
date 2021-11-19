<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * @property int|string|null id
 * @property int|string user_id
 * @property string title
 * @property string order
 * @property string color
 * @property int created_at
 * @property int updated_at
 *
 * @property User owner
 *
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'color',
    ];

    public function __construct(array $attributes = [])
    {
        $this->user_id = Auth::id();

        parent::__construct($attributes);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
