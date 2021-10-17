<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    private $fullResource = false;

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
        return $this->hasOne(Folder::class, 'folder_id', 'id');
    }

    public function categories() {
        return $this->hasOne(Category::class, 'category_id', 'id');
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
