<?php

namespace App\Http\Resources;

class UserCreatedResource extends ApiResource
{
    public function __construct($user)
    {
        parent::__construct(UserResource::make($user)->resource, 201);
    }
}
