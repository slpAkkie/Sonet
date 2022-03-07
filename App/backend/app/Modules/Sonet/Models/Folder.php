<?php

namespace App\Modules\Sonet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

/**
 * @property int|string|null id
 * @property string title
 * @property string order
 * @property int|string user_id
 *
 * @property User owner
 * @property Collection<Note> notes
 *
 * @mixin Builder
 */
class Folder extends Model
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
    ];



    /*
    |--------------------------------------------------
    | Methods
    |--------------------------------------------------
    */

    public function __construct(array $attributes = [])
    {
        $this->user_id = Auth::id();
        $this->order = 0;
        parent::__construct($attributes);
    }


    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * Folder owner
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * All notes with the folder
     *
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'folder_id', 'id');
    }
}
