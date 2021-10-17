<?php

namespace App\Http\Resources;

class AuthorizationExceptionResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('У вас нет доступа к этому ресурсу', 403);
    }
}
