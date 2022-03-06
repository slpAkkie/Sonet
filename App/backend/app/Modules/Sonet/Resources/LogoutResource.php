<?php

namespace App\Modules\Sonet\Resources;

final class LogoutResource extends \App\Http\Resources\CommonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Выход',
        ];
    }
}
