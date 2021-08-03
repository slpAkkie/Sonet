<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\NoContentResource;
use App\Http\Resources\TokenResource;
use App\Http\Resources\ValidationFailedResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        (new User($request->all()))
            ->setPassword($request->get('password'))
            ->save();

        return new NoContentResource();
    }

    public function login(LoginRequest $request)
    {
        if ($user = User::FindAndCheck($request->get('login'), $request->get('password'))) return new TokenResource($user->generateToken());

        return new ValidationFailedResource([
            'password' => ['Вы не правильно указали пароль']
        ]);
    }

    public function logout(Request $request)
    {
        Auth::user()->removeToken();
        return new NoContentResource();
    }
}
