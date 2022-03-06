<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\AccessLevel;

/**
 * @mixin AccessLevel
 */
class AccessLevelResource extends \App\Http\Resources\CommonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
