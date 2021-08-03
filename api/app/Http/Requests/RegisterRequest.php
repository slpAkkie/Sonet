<?php

namespace App\Http\Requests;

class RegisterRequest extends ApiRequest
{
    public function messages()
    {
        return [
            'email.required'        => 'Вы не указали почту',
            'email.email'           => 'К сожалению это не похоже на адрес элетронной почты',
            'email.unique'          => 'Похоже этот адрес электронной почты уже используется',
            'nickname.required'     => 'Никнейм не указан',
            'nickname.regex'        => 'Ваш никнейм содержит странные символы, поменяйте, пожалуйста',
            'login.required'        => 'Вы не указали логин',
            'login.regex'           => 'Ваш логин содержит странные символы, поменяйте, пожалуйста',
            'login.unique'          => 'Похоже этот логин уже используется',
            'password.required'     => 'Вы не указали пароль',
            'password.confirmed'    => 'Пароли не похожи',
        ];
    }

    public function rules()
    {
        return [
            'email'     => 'required|email|unique:users',
            'nickname'  => 'required|regex:/^[A-Za-z0-9_\-\.\[\]&#@\^\$\!]+$/u',
            'login'     => 'required|regex:/^[A-Za-z0-9_\-\.\[\]&#@\^\$\!]+$/u|unique:users',
            'password'  => 'required|confirmed',
        ];
    }
}
