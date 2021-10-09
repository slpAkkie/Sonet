<?php

namespace App\Http\Resources;

class LogoutResource extends CommonResource
{
    public function __construct()
    {
        parent::__construct([
            'message' => 'Выход'
        ]);
    }
}
