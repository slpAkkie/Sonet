<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\Folder;

/**
 * @mixin Folder
 */
final class FolderResource extends \App\Http\Resources\CommonResource
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
