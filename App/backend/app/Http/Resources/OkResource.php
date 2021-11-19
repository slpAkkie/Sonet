<?php

namespace App\Http\Resources;

final class OkResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'OK',
        ];
    }
}
