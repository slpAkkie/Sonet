<?php

namespace App\Http\Resources\Exceptions;

final class NotFoundHttpResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('По этому адресу ничего нет', 404);
    }
}
