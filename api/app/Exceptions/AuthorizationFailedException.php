<?php

namespace App\Exceptions;

use App\Http\Resources\AuthorizationFailedResource;
use Exception;

class AuthorizationFailedException extends Exception
{
    /**
     * Get response
     *
     * @return AuthorizationFailedResource
     */
    public function response()
    {
        return new AuthorizationFailedResource();
    }
}
