<?php

namespace App\Http\Resources;

class ApiTokenAuthorizationResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('Ваш токен не действительный', 401);
    }
}
