<?php

namespace App\Http\Resources;

class AuthorizedUserResource extends CommonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'login' => $this->login,
            'email' => $this->email,
            'api_token' => $this->api_token,
        ];
    }
}
