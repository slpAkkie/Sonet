<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            $this->mergeWhen($this->withFullResource(), [
                'folder_id' => $this->folder_id,
                'updated_at' => $this->updated_at
            ])
        ];
    }
}
