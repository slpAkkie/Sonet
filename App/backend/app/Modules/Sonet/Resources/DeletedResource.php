<?php

namespace App\Modules\Sonet\Resources;

final class DeletedResource extends \App\Http\Resources\CommonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Удалено',
        ];
    }
}
