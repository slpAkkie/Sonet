<?php

namespace App\Http\Requests;

class LoginRequest extends ApiRequest
{
    public function messages()
    {
        return [
            'login.required'            => 'Вы не указали логин',
            'login.exists'               => 'Мы не смогли найти такого пользователя',
            'password.required'         => 'Вы не указали пароль',
        ];
    }

    public function rules()
    {
        return [
            'login'     => 'required|exists:users',
            'password'  => 'required',
        ];
    }
}
