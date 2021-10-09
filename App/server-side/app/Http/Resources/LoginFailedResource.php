<?php

namespace App\Http\Resources;

class LoginFailedResource extends ValidationFailedResource
{
    public function __construct()
    {
        parent::__construct([ 'login' => 'Пользователь с таким логином или паролем не найден' ]);
    }
}
