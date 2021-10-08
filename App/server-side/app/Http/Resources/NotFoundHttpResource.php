<?php

namespace App\Http\Resources;

class NotFoundHttpResource extends ApiErrorResource
{
    public function __construct()
    {
        parent::__construct('Ничего не найдено', 404);
    }
}
