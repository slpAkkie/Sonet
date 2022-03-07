<?php

namespace App\Modules\Sonet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
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
 * @property Collection<Note> notes
 *
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;

    protected $connection = 'sonet';



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
        'title',
        'color',
    ];



    /*
    |--------------------------------------------------
    | Methods
    |--------------------------------------------------
    */

    public function __construct(array $attributes = [])
    {
        $this->user_id = Auth::id();

        parent::__construct($attributes);
    }

    /**
     * Update the category
     *
     * @param array $attributes
     * @param array $options
     * @return $this
     */
    public function update(array $attributes = [], array $options = []): Category
    {
        $this->title = $attributes['title'];
        $this->color = $attributes['color'];

        $this->save();

        return $this;
    }


    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * Category owner
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * All notes with the category
     *
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'category_id', 'id');
    }
}
