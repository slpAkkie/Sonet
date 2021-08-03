<?php

namespace App\Exceptions;

use App\Http\Resources\UnauthorizedResource;
use Exception;

class UnauthorizedException extends Exception
{
    /**
     * Get response
     *
     * @return UnauthorizedResource
     */
    public function response()
    {
        return new UnauthorizedResource();
    }
}
