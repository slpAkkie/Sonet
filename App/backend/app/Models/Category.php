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

    public function update(array $attributes = [], array $options = [])
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
}
