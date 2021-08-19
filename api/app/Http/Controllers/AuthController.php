<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\NoContentResource;
use App\Http\Resources\TokenResource;
use App\Http\Resources\ValidationFailedResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Try to register new user with provided data
     *
     * @param RegisterRequest $request
     * @return NoContentResource
     */
    public function register(RegisterRequest $request): NoContentResource
    {
        (new User($request->all()))
            ->setPassword($request->get('password'))
            ->save();

        return new NoContentResource();
    }

    /**
     * Try to login user by provided data
     *
     * @param LoginRequest $request
     * @return TokenResource|ValidationFailedResource
     */
    public function login(LoginRequest $request): TokenResource|ValidationFailedResource
    {
        /** @var User|bool $user */
        $user = User::FindAndCheckPassword($request->get('login'), $request->get('password'));
        if (!$user) return new ValidationFailedResource([
            'password' => ['Вы не правильно указали пароль']
        ]);

        return new TokenResource($user->generateToken());
    }

    /**
     * Try to logout user
     *
     * @return NoContentResource
     */
    public function logout(): NoContentResource
    {
        Auth::user()->removeToken();
        return new NoContentResource();
    }
}
