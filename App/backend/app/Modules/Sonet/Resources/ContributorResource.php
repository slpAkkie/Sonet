<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\User;

/**
 * @mixin User
 */
class ContributorResource extends \App\Http\Resources\CommonResource
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
