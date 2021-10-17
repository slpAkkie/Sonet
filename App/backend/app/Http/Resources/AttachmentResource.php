<?php

namespace App\Http\Resources;

class AttachmentResource extends CommonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => $this->path,
        ];
    }
}
