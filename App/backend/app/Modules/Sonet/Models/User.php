<?php

namespace App\Modules\Sonet\Models;

use App\Exceptions\NoApiTokenProvidedException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

/**
 * @property int|string|null id
 * @property string first_name
 * @property string last_name
 * @property string login
 * @property string email
 * @property string password_salt
 * @property string password
 *
 * @property UserToken|null api_token
 * @property Collection<UserToken>|null tokens
 *
 * @mixin Builder
 */
class User extends \App\Models\User
{

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
        'first_name',
        'last_name',
        'login',
        'email',
    ];

    /**
     * Current token
     *
     * @var null|UserToken
     */
    public $api_token = null;



    /*
    |--------------------------------------------------
    | Custom properties
    |--------------------------------------------------
    */

    /**
     * User access level to the note
     * Necessary when set a contributor to the note
     *
     * @var null|AccessLevel
     */
    public $access_level = null;



    /*
    |--------------------------------------------------
    | Methods
    |--------------------------------------------------
    */

    /**
     * Set access level
     *
     * @param AccessLevel $accessLevel
     * @return $this
     */
    public function setAccessLevel(AccessLevel $accessLevel): User
    {
        $this->access_level = $accessLevel;

        return $this;
    }

    /**
     * Get access level title
     *
     * @return string
     */
    public function getAccessLevel(): string
    {
        return $this->access_level ? $this->access_level->title : AccessLevel::find($this->pivot->access_level_id, 'title')->title;
    }

    /**
     * Get user full name
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->last_name . ' ' . $this->first_name;
    }

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
     * Find user by email.
     *
     * @param $email
     * @return User|null
     */
    public static function findByEmail($email): ?User
    {
        return User::where('email', $email)->first();
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
     * Set current user token
     *
     * @param UserToken $token
     * @return $this
     */
    public function setToken(UserToken $token): User
    {
        $this->api_token = $token;

        return $this;
    }

    /**
     * Get current token
     *
     * @return UserToken|null
     */
    public function getCurrentToken(): ?UserToken
    {
        return $this->api_token;
    }

    /**
     * Get just current token string
     *
     * @return string
     */
    public function getCurrentTokenString(): string
    {
        return $this->getCurrentToken() ? $this->getCurrentToken()->token : '';
    }

    /**
     * Check if token is set
     *
     * @return bool
     */
    public function isToken(): bool
    {
        return !!$this->api_token;
    }

    /**
     * Generate new token.
     *
     * @return $this
     */
    public function generateToken(): User
    {
        $api_token = Str::random(64);
        while (!!UserToken::where('token', $api_token)->count())
            $api_token = Str::random(64);

        ($userToken = new UserToken([
            'token' => $api_token,
            'user_id' => $this->id,
            'user_agent' => Request::userAgent(),
        ]))->save();

        return $this->setToken($userToken);
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
        $token = UserToken::where('token', $api_token)->first();
        if (!$token) throw new NoApiTokenProvidedException();

        /** @var User $user */
        $user = $token->user;
        $token->touch();

        return $user->setToken($token);
    }

    /**
     * Remove user's token.
     *
     * @return $this
     */
    public function removeToken(): User
    {
        $this->getCurrentToken()->delete();

        return $this;
    }



    /*
    |--------------------------------------------------
    | Relations
    |--------------------------------------------------
    */

    /**
     * All tokens related to this user
     *
     * @return HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(UserToken::class, 'user_id', 'id');
    }

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
