<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\Attachment;

/**
 * @mixin Attachment
 */
final class AttachmentResource extends \App\Http\Resources\CommonResource
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
