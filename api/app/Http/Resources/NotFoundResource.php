<?php

namespace App\Http\Resources;

class NotFoundResource extends ErrorResource
{
    public function __construct()
    {
        parent::__construct('Мы ничего не нашли', 404);
    }
}
