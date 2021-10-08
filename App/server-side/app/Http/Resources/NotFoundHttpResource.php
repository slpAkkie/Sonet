<?php

namespace App\Http\Resources;

class NotFoundHttpResource extends ApiErrorResource
{
    public function __construct()
    {
        parent::__construct('По запросу ничего не найдено', 404);
    }
}
