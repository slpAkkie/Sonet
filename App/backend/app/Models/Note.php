<?php

namespace App\Models;

use App\Exceptions\ModelNotSavedException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'category_id',
        'folder_id',
        'user_id',
    ];

    private $fullResource = false;

    public function __construct(array $attributes = [])
    {
        $attributes['user_id'] = Auth::id();
        parent::__construct($attributes);
    }

    /**
     * @throws ModelNotSavedException
     */
    public function addAttachments($attachmentsData) {
        if (!$this->id) throw new ModelNotSavedException();

        $attachments = [];

        foreach ($attachmentsData as $attachment)
            $attachments[] = new Attachment($attachment);

        $this->attachments()->saveMany($attachments);
    }

    public function withFullResource() {
        return $this->fullResource;
    }

    public function setWithFullResource() {
        $this->fullResource = true;
    }

    public function attachments() {
        return $this->hasMany(Attachment::class, 'note_id', 'id');
    }

    public function folder() {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'note_id', 'id');
    }

    public function sharedWith() {
        return $this->belongsToMany(User::class, 'note_users', 'note_id', 'user_id')->withPivot('access_level_id');
    }
}
