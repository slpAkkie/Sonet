<?php

namespace App\Http\Resources\Exceptions;

final class LoginFailedResource extends ValidationFailedResource
{
    public function __construct()
    {
        parent::__construct([ 'login' => 'Пользователь с таким логином или паролем не найден' ]);
    }
}
