<?php

namespace App\Http\Resources;

use App\Models\Folder;

/**
 * @mixin Folder
 */
final class FolderResource extends CommonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'notes_amount' => $this->notes()->count(),
        ];
    }
}
