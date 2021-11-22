<?php

namespace App\Http\Resources\Exceptions;

final class MethodNotAllowedHttpResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('Метод, который вы используете не поддерживается на этом адресе', 404);
    }
}
