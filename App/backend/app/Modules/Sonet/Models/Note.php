<?php

namespace App\Modules\Sonet\Models;

use App\Modules\Sonet\Observers\NoteObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * @property int|string|null id
 * @property string title
 * @property string body
 * @property int|string folder_id
 * @property int|string category_id
 * @property int|string user_id
 * @property int created_at
 * @property int updated_at
 *
 * @property Category category
 * @property Folder folder
 * @property Collection<Attachment> attachments
 * @property User author
 * @property Collection<Comment> comments
 * @property Collection<User> sharedWith
 * @property Collection<User> contributors
 *
 * @mixin Builder
 */
class Note extends Model
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
        'body',
        'category_id',
        'folder_id',
    ];



    /*
    |--------------------------------------------------
    | Custom properties
    |--------------------------------------------------
    */

    /**
     * Determines whether the resource should output attachments.
     *
     * @var bool
     */
    private $resourceWithAttachments = false;

    private $resourceWithFullBody = false;

    /**
     * Attachments that must be stored after the note is saved.
     *
     * @var array
     */
    private $attachmentsToStore = [];



    /*
    |--------------------------------------------------
    | Override
    |--------------------------------------------------
    */

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new NoteObserver);
    }



    /*
    |--------------------------------------------------
    | Methods
    |--------------------------------------------------
    */

    /**
     * Create new Note.
     *
     * @param $attributes
     * @return Note
     */
    static public function new($attributes): Note
    {
        $note = new self($attributes);

        $note->user_id = Auth::id();

        if (key_exists('attachments', $attributes)) $note->attachmentsToStore = $attributes['attachments'];

        return $note;
    }

    /**
     * Store all attachments to be stored.
     */
    public function storeAttachments()
    {
        // TODO: Store attachments
    }

    /**
     * Add comment to the note and store it
     *
     * @param $body
     * @return Model
     */
    public function addComment($body): Model
    {
        return $this->comments()->create([
            'body' => $body,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Does the resource have to output attachments.
     *
     * @return bool
     */
    public function isResourceWithAttachments(): bool
    {
        return $this->resourceWithAttachments;
    }

    /**
     * Does the resource have to output with full body.
     *
     * @return bool
     */
    public function isResourceWithFullBody(): bool
    {
        return $this->resourceWithFullBody;
    }

    /**
     * Set the resource to output attachments.
     *
     * @return $this
     */
    public function setFullResource(): Note
    {
        $this->resourceWithAttachments = true;
        $this->resourceWithFullBody = true;

        return $this;
    }



    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * Note attachments.
     *
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'note_id', 'id');
    }

    /**
     * Note folder.
     *
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }

    /**
     * Note category.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Note author.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Note comments.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'note_id', 'id');
    }

    /**
     * Note contributors.
     *
     * @return BelongsToMany
     */
    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'note_users', 'note_id', 'user_id')->withPivot('access_level_id');
    }
}
