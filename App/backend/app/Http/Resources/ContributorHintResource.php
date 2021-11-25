<?php

namespace App\Http\Resources;

use App\Models\User;

/**
 * @mixin User
 */
class ContributorHintResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'full_name' => $this->getFullName()
        ];
    }
}
