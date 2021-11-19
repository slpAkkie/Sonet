<?php

namespace App\Http\Resources;

class TestResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Тест',
        ];
    }
}
