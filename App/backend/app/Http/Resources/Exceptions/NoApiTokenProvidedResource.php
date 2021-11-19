<?php

namespace App\Http\Resources\Exceptions;

final class NoApiTokenProvidedResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('У вас нет доступа к этой странице, вам необходимо пройти авторизацию', 401);
    }
}
