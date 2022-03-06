<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\User;

/**
 * @mixin User
 */
class UserResource extends \App\Http\Resources\CommonResource
{
    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'login' => $this->login,
            'email' => $this->email,
            'api_token' => $this->when($this->isToken(), $this->getCurrentTokenString()),
        ];
    }
}
