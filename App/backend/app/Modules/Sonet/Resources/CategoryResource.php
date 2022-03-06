<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\Category;

/**
 * @mixin Category
 */
final class CategoryResource extends \App\Http\Resources\CommonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'color' => $this->color,
            'order' => $this->order,
            'notes_amount' => $this->notes()->count(),
        ];
    }
}
