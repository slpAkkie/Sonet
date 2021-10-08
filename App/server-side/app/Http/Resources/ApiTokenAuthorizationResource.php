<?php

namespace App\Http\Resources;

class ApiTokenAuthorizationResource extends ApiErrorResource
{
    public function __construct()
    {
        parent::__construct('Ваш токен не действительный', 401);
    }
}
