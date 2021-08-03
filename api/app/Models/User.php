<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'nickname',
        'login',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'salt',
        'token',
        'password'
    ];

    public function setPassword($password)
    {
        $this->salt = Hash::make(Str::random(32) . $this->login);
        $this->password = Hash::make($password . $this->salt);

        return $this;
    }

    public function checkPassword($password)
    {
        return Hash::check($password . $this->salt, $this->password);
    }

    public static function FindAndCheck($login, $password)
    {
        return (($user = self::where('login', $login)->first()) && $user->checkPassword($password)) ? $user : false;
    }

    public function generateToken()
    {
        $this->token = Hash::make(Str::random(32) . $this->salt . Carbon::now());
        $this->save();

        return $this->token;
    }

    public function removeToken()
    {
        $this->token = null;
        $this->save();

        return $this;
    }

    public static function getByToken($token)
    {
        return $token ? User::where('token', $token)->first() : null;
    }
}
