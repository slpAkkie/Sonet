<?php

namespace App\Http\Resources;

class LoginFailedResource extends ApiErrorResource
{
    public function __construct()
    {
        parent::__construct('Ошибка входа', 401, [
            'login' => 'Пользователь с таким логином или паролем не найден'
        ]);
    }
}
