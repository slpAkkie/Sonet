<?php

namespace App\Http\Resources;

class DeletedResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Удалено'
        ];
    }
}
