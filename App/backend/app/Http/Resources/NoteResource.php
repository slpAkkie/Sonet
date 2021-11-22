<?php

namespace App\Http\Resources;

use App\Models\Note;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
            'body' => $this->when($this->isResourceWithFullBody(), $this->body, Str::limit($this->body, 120)),

            'category' => $this->when(!!$this->category, function () {
                return $this->category->id;
            }, null),
            'folder' => $this->when(!!$this->folder, function () {
                return $this->folder->id;
            }, null),
            $this->mergeWhen($this->isResourceWithAttachments(), [
                'attachments' => $this->when($this->attachments->count(), function () {
                    return AttachmentResource::collection($this->attachments);
                }, []),
            ]),

            'created_at' => Carbon::parse($this->created_at)->toDateTimeLocalString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeLocalString(),
        ];
    }
}
