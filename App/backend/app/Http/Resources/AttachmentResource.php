<?php

namespace App\Http\Resources;

use App\Models\Attachment;

/**
 * @mixin Attachment
 */
final class AttachmentResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => $this->path,
        ];
    }
}
