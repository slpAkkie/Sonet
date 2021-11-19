<?php

namespace App\Http\Resources;

use App\Models\Note;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @mixin Note
 */
final class NoteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,

            'category' => $this->when(!!$this->category, [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'color' => $this->category->color,
            ]),
            'folder' => $this->when(!!$this->folder, [
                'id' => $this->folder->id,
                'title' => $this->folder->title,
            ]),
            $this->mergeWhen($this->isWithAttachments(), [
                'attachments' => $this->when($this->attachments->count(), function () {
                    return AttachmentResource::collection($this->attachments);
                }, []),
            ]),

            'created_at' => Carbon::parse($this->created_at)->toDateTimeLocalString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeLocalString(),
        ];
    }
}
