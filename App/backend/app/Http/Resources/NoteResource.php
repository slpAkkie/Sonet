<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class NoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category' => $this->when($this->category, function () {
                return [
                    'title' => $this->category->title,
                    'color' => $this->category->color,
                ];
            }),

            $this->mergeWhen($this->withFullResource(), [
                'folder' => $this->when($this->folder, function () {
                    return $this->folder->title;
                }),
                'attachments' => $this->when($this->attachments->count(), function () {
                    return AttachmentResource::collection($this->attachments);
                }),
            ]),

            'created_at' => Carbon::parse($this->created_at)->toDateTimeLocalString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeLocalString(),
        ];
    }
}
