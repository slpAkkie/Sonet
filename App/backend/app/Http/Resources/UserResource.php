<?php

namespace App\Http\Resources;

/**
 * @property string first_name
 * @property string last_name
 * @property string login
 * @property string email
 * @property string api_token
 */
final class UserResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'login' => $this->login,
            'email' => $this->email,
            'api_token' => $this->when($this->api_token, $this->api_token),
        ];
    }
}
