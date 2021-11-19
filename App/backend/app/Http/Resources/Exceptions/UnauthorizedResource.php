<?php

namespace App\Http\Resources\Exceptions;

final class UnauthorizedResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('У вас нет доступа к этому ресурсу', 403);
    }
}
