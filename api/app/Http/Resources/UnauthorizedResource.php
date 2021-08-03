<?php

namespace App\Http\Resources;

class UnauthorizedResource extends ErrorResource
{
    /**
     * UnauthenticatedResource constructor.
     */
    public function __construct()
    {
        parent::__construct('Вы забыли авторизоваться', 401);
    }
}
