<?php

namespace App\Http\Resources;

class UserResource extends ApiResource
{
    public function __construct($user)
    {
        parent::__construct([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'login' => $user->login,
            'email' => $user->email,
        ]);
    }
}
