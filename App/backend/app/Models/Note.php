<?php

namespace App\Models;

use App\Exceptions\RecordDoesntExistException;
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
 *
 * @mixin Builder
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'category_id',
        'folder_id',
    ];

    private $withAttachmentsResource = false;

    public function __construct(array $attributes = [])
    {
        $this->user_id = Auth::id();
        parent::__construct($attributes);
    }

    /**
     * @throws RecordDoesntExistException
     */
    public function addAttachments($attachmentsData) {
        if (!$this->id) throw new RecordDoesntExistException();

        $attachments = [];

        foreach ($attachmentsData as $attachment)
            $attachments[] = new Attachment($attachment);

        $this->attachments()->saveMany($attachments);
    }

    public function isWithAttachments(): bool
    {
        return $this->withAttachmentsResource;
    }

    public function setWithAttachments() {
        $this->withAttachmentsResource = true;
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'note_id', 'id');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'note_id', 'id');
    }

    public function sharedWith(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'note_users', 'note_id', 'user_id')->withPivot('access_level_id');
    }
}
