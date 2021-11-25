<?php

namespace App\Http\Resources;

use App\Models\User;

/**
 * @mixin User
 */
class ContributorResource extends CommonResource
{
    public function toArray($request)
    {
        return [
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
                'full_name' => $this->getFullName(),
            ],
            'access_level' => $this->getAccessLevel(),
        ];
    }
}
