<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'login',
        'email'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function notes() {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    public function sharedWithMe() {
        return $this->belongsToMany(Note::class, 'note_users', 'user_id', 'note_id')->withPivot('access_level_id');
    }

    public function folders() {
        return $this->hasMany(Folder::class, 'user_id', 'id');
    }

    public function category() {
        return $this->hasMany(Category::class, 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }



    public static function findByToken($api_token) {
        return User::where('api_token', $api_token)->firstOrFail();
    }
}
