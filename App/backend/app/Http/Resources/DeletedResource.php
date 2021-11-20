<?php

namespace App\Http\Resources;

final class DeletedResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Удалено',
        ];
    }
}
