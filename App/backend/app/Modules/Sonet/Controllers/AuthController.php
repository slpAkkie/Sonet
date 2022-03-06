<?php

namespace App\Modules\Sonet\Controllers;

use App\Exceptions\LoginIncorrectException;
use App\Exceptions\PasswordIncorrectException;
use App\Modules\Sonet\Requests\LoginRequest;
use App\Modules\Sonet\Requests\RegisterRequest;
use App\Modules\Sonet\Resources\AuthLogResource;
use App\Http\Resources\CommonResource;
use App\Modules\Sonet\Resources\DeletedResource;
use App\Modules\Sonet\Resources\LogoutResource;
use App\Http\Resources\OkResource;
use App\Modules\Sonet\Resources\UserCreatedResource;
use App\Modules\Sonet\Resources\UserResource;
use App\Modules\Sonet\Models\User;
use App\Modules\Sonet\Models\UserToken;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class AuthController extends \App\Http\Controllers\Controller
{
    /**
     * User registration.
     *
     * @param RegisterRequest $request
     * @return UserCreatedResource
     */
    public function register(RegisterRequest $request): UserCreatedResource
    {
        $user = User::new($request->all());

        return UserCreatedResource::make($user);
    }

    /**
     * Try to login with provided data.
     *
     * @throws PasswordIncorrectException
     * @throws LoginIncorrectException
     */
    public function login(LoginRequest $request): UserResource
    {
        $user = User::findByLogin($request->get('login'));

        if (!$user) throw new LoginIncorrectException();
        elseif (!$user->checkPassword($request->get('password'))) throw new PasswordIncorrectException();

        $user->generateToken();

        return UserResource::make($user);
    }

    /**
     * Return ok, because this method allowed only for successfully authenticated users.
     * Necessary to check the correctness of the saved token on the client.
     *
     * @return CommonResource
     */
    public function verify(): CommonResource
    {
        return OkResource::make();
    }

    /**
     * Get information about authenticated user.
     *
     * @return UserResource
     */
    public function identify(): UserResource
    {
        return UserResource::make(Auth::user());
    }

    /**
     * Get all auth events for the user
     *
     * @return AnonymousResourceCollection
     */
    public function authLog(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();
        return AuthLogResource::collection($user->tokens()->orderByDesc('created_at')->get());
    }

    /**
     * Deactivate authentication record
     *
     * @param UserToken $userToken
     * @return DeletedResource
     */
    public function removeAuthRecord(UserToken $userToken): DeletedResource
    {
        $userToken->delete();

        return DeletedResource::make();
    }

    /**
     * Handle logout.
     *
     * @return LogoutResource
     */
    public function logout(): LogoutResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->removeToken();

        return LogoutResource::make();
    }
}
