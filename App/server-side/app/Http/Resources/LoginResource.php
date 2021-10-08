<?php

namespace App\Http\Resources;

class LoginResource extends ApiResource
{
    public function __construct($user)
    {
        parent::__construct(AuthorizedUserResource::make($user)->resource);
    }
}
