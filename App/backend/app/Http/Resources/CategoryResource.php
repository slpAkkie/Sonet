<?php

namespace App\Http\Resources;

class CategoryResource extends CommonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
        ];
    }
}
