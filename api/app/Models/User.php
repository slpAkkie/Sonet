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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'nickname',
        'login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'salt',
        'token',
        'password'
    ];

    /**
     * Set password for the user and save it
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): User
    {
        $this->salt = Hash::make(Str::random(32) . $this->login);
        $this->password = Hash::make($password . $this->salt);

        return $this;
    }

    /**
     * Check if provided and user's passwords are equal
     *
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return Hash::check($password . $this->salt, $this->password);
    }

    /**
     * Find user by the login and check if the password is correct
     *
     * @param $login
     * @param $password
     * @return User|bool
     */
    public static function FindAndCheckPassword($login, $password): User|bool
    {
        return (($user = self::where('login', $login)->first()) && $user->checkPassword($password)) ? $user : false;
    }

    /**
     * Set user's token to the value
     *
     * @param string|null $value
     * @return string|null
     */
    private function setToken(string|null $value): string|null
    {
        $this->token = $value;
        $this->save();

        return $value;
    }

    /**
     * Generate new token for user and save it
     *
     * @return string
     */
    public function generateToken(): string
    {
        return $this->setToken(Hash::make(Str::random(32) . $this->salt . Carbon::now()));
    }

    /**
     * Remove user's token
     *
     * @return User
     */
    public function removeToken(): User
    {
        $this->setToken(null);

        return $this;
    }

    /**
     * Find user by the token
     *
     * @param $token
     * @return User|null
     */
    public static function findByToken($token): User|null
    {
        return $token ? self::where('token', '=', $token)->first() : null;
    }
}
