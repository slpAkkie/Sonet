<?php

namespace App\Http\Resources;

use App\Models\AccessLevel;

/**
 * @mixin AccessLevel
 */
class AccessLevelResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
