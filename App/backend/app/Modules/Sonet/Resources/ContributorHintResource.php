<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\User;

/**
 * @mixin User
 */
class ContributorHintResource extends \App\Http\Resources\CommonResource
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
