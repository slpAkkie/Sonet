<?php

namespace App\Http\Controllers;

use App\Exceptions\PasswordIncorrectException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LogoutResource;
use App\Http\Resources\UserCreatedResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): UserCreatedResource
    {
        $user = new User($request->all());
        $user->setPassword($request->get('password'));

        return UserCreatedResource::make($user);
    }

    /**
     * @throws PasswordIncorrectException
     * @throws UserNotFoundException
     */
    public function login(LoginRequest $request) {
        $user = User::findByLogin($request->get('login'));
        if (!$user) throw new UserNotFoundException();
        elseif (!$user->checkPassword($request->get('password'))) throw new PasswordIncorrectException();

        $user->generateToken();

        return UserResource::make($user);
    }

    public function logout() {
        Auth::user()->removeToken();

        return LogoutResource::make();
    }

    public function getUserByToken() {
        return UserResource::make(Auth::user());
    }

    public function checkToken() {
        return \App\Http\Resources\CommonResource::make(['message' => 'ok']);
    }
}
