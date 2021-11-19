<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginIncorrectException;
use App\Exceptions\PasswordIncorrectException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\CommonResource;
use App\Http\Resources\LogoutResource;
use App\Http\Resources\OkResource;
use App\Http\Resources\UserCreatedResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class AuthController extends Controller
{
    /**
     * User registration
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
     * Try to login with provided data
     *
     * @throws PasswordIncorrectException
     * @throws LoginIncorrectException
     */
    public function login(LoginRequest $request): UserResource
    {
        /** @var User $user */
        $user = User::findByLogin($request->get('login'));

        if (!$user) throw new LoginIncorrectException();
        elseif (!$user->checkPassword($request->get('password'))) throw new PasswordIncorrectException();

        $user->generateToken();

        return UserResource::make($user);
    }

    /**
     * Handle logout
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

    /**
     * @return UserResource
     */
    public function getAuthenticatedUser(): UserResource
    {
        return UserResource::make(Auth::user());
    }

    /**
     * Return ok, because this method allowed only for successfully authenticated users
     *
     * @return CommonResource
     */
    public function checkToken(): CommonResource
    {
        return OkResource::make();
    }
}
