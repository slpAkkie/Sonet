<?php

namespace App\Http\Resources;

class FolderResource extends CommonResource
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
