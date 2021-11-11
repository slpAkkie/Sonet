<?php

namespace App\Models;

use App\Exceptions\ApiTokenAuthorizationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function notes() {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    public function sharedWithMe() {
        return $this->belongsToMany(Note::class, 'note_users', 'user_id', 'note_id')->withPivot('access_level_id');
    }

    public function folders() {
        return $this->hasMany(Folder::class, 'user_id', 'id');
    }

    public function categories() {
        return $this->hasMany(Category::class, 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }



    public static function findByToken($api_token) {
        return User::where('api_token', $api_token)->firstOr(/**
         * @throws ApiTokenAuthorizationException
         */ function () {
            return throw new ApiTokenAuthorizationException();
        });
    }

    public static function findByLogin($login) {
        return User::where('login', $login)->first();
    }

    public function checkPassword($password) {
        return Hash::check($password . $this->password_salt, $this->password);
    }

    public function setPassword($password) {
        $this->generateSalt();
        $this->password = Hash::make($password . $this->password_salt);
        $this->save();

        return $this;
    }

    private function generateSalt() {
        $salt = Str::random(128);
        while (!!static::where('password_salt', $salt)->count())
            $salt = Str::random(128);

        $this->password_salt = $salt;

        return $this;
    }

    public function generateToken() {
        $api_token = Str::random(64);
        while (!!static::where('api_token', $api_token)->count())
            $api_token = Str::random(64);

        $this->api_token = $api_token;
        $this->save();

        return $this;
    }

    public function removeToken() {
        $this->api_token = null;
        $this->save();
    }
}
