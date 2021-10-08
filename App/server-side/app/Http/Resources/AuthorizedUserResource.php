<?php

namespace App\Http\Resources;

class AuthorizedUserResource extends ApiResource
{
    public function __construct($user)
    {
        parent::__construct([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'login' => $user->login,
            'email' => $user->email,
            'api_token' => $user->api_token,
        ]);
    }
}
