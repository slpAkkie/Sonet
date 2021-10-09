<?php

namespace App\Http\Resources;

class UserResource extends CommonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'login' => $this->login,
            'email' => $this->email,
        ];
    }
}
