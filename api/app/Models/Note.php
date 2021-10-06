<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function attachments() {
        return $this->hasMany(Attachment::class, 'note_id', 'id');
    }

    public function folder() {
        return $this->hasOne(Folder::class, 'id', 'folder_id');
    }

    public function categories() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'note_id', 'id');
    }

    public function sharedWith() {
        return $this->belongsToMany(User::class, 'note_users', 'note_id', 'user_id')->withPivot('access_level_id');
    }
}
