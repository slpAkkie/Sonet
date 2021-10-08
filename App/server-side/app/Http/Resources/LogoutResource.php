<?php

namespace App\Http\Resources;

class LogoutResource extends ApiResource
{
    public function __construct()
    {
        parent::__construct([
            'message' => 'Выход'
        ]);
    }
}
