<?php

namespace App\Models;

use App\Exceptions\NoApiTokenProvidedException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @property int|string|null id
 * @property string first_name
 * @property string last_name
 * @property string login
 * @property string email
 * @property string password_salt
 * @property string password
 * @property string|null api_token
 *
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasFactory;



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
        'first_name',
        'last_name',
        'login',
        'email',
    ];



    /*
    |--------------------------------------------------
    | Methods
    |--------------------------------------------------
    */

    /**
     * Register new User.
     *
     * @param $attributes
     * @return User
     */
    static public function new($attributes): User
    {
        $user = new self($attributes);

        $user->setPassword($attributes['password']);

        return $user;
    }

    /**
     * Set user's password.
     *
     * @param $password
     * @return $this
     */
    public function setPassword($password): User
    {
        $this->generateSalt();
        $this->password = $this->hashPassword($this->saltPassword($password));
        $this->save();

        return $this;
    }

    /**
     * Generate new salt.
     *
     * @return User
     */
    private function generateSalt(): User
    {
        $this->password_salt = Str::random(128);

        return $this;
    }

    /**
     * Match the password with the salt.
     *
     * @param string $password
     * @return string
     */
    private function saltPassword(string $password): string
    {
        return $password . $this->password_salt;
    }

    /**
     * Hash user's salted password.
     *
     * @param string $password
     * @return string
     */
    private function hashPassword(string $password): string
    {
        return Hash::make($this->saltPassword($password) . $this->password_salt);
    }

    /**
     * Find user by login.
     *
     * @param $login
     * @return User|null
     */
    public static function findByLogin($login): ?User
    {
        return User::where('login', $login)->first();
    }

    /**
     * Check if password correct for this user.
     *
     * @param $password
     * @return bool
     */
    public function checkPassword($password): bool
    {
        return Hash::check($this->saltPassword($password), $this->password);
    }

    /**
     * Generate new token.
     *
     * @return $this
     */
    public function generateToken(): User
    {
        $api_token = Str::random(64);
        while (!!static::where('api_token', $api_token)->count())
            $api_token = Str::random(64);

        $this->api_token = $api_token;
        $this->save();

        return $this;
    }

    /**
     * Find user by token.
     *
     * @param $api_token
     * @return User
     * @throws NoApiTokenProvidedException
     */
    public static function findByTokenOrFail($api_token): User
    {
        $user = User::where('api_token', $api_token)->first();
        if (!$user) throw new NoApiTokenProvidedException();

        return $user;
    }

    /**
     * Remove user's token.
     *
     * @return $this
     */
    public function removeToken(): User
    {
        $this->api_token = null;
        $this->save();

        return $this;
    }



    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * User's notes.
     *
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    /**
     * User's notes ordered by updated_at column.
     *
     * @return Collection
     */
    public function notesOrderedByUpdate(): Collection
    {
        return $this->notes()->orderByDesc('updated_at')->get();
    }

    /**
     * User's notes shared with him.
     *
     * @return BelongsToMany
     */
    public function contributorIn(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_users', 'user_id', 'note_id')->withPivot('access_level_id');
    }

    /**
     * User's notes shared with him ordered by updated_at column.
     *
     * @return Collection
     */
    public function contributorInOrderedByUpdate(): Collection
    {
        return $this->contributorIn()->orderByDesc('updated_at')->get();
    }

    /**
     * User's created folders.
     *
     * @return HasMany
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class, 'user_id', 'id');
    }

    /**
     * User's created categories.
     *
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'user_id', 'id');
    }

    /**
     * User's comments.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
