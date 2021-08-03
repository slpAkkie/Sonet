<?php

namespace App\Http\Resources;

class AuthorizationFailedResource extends ErrorResource
{
    /**
     * AuthorizationFailedResource constructor.
     */
    public function __construct()
    {
        parent::__construct('Извините, но вам сюда нельзя', 403);
    }
}
