<?php

namespace App\Modules\Sonet\Controllers;

use App\Modules\Sonet\Requests\StoreAttachmentRequest;
use App\Modules\Sonet\Resources\AttachmentResource;
use App\Modules\Sonet\Resources\DeletedResource;
use App\Http\Resources\Exceptions\UnauthorizedResource;
use App\Modules\Sonet\Models\Attachment;
use App\Modules\Sonet\Models\Note;
use Illuminate\Support\Facades\Gate;

class AttachmentController extends \App\Http\Controllers\Controller
{
    /**
     * Store attachment
     *
     * @param StoreAttachmentRequest $request
     * @param Note $note
     * @return AttachmentResource
     */
    public function store(StoreAttachmentRequest $request, Note $note): AttachmentResource
    {
        return AttachmentResource::make(Attachment::new($request->file('attachment'), $note->id));
    }

    /**
     * Delete attachment
     *
     * @param Attachment $attachment
     * @return DeletedResource|UnauthorizedResource
     */
    public function destroy(Attachment $attachment)
    {
        if (!Gate::authorize('update-note', $attachment->note)) return UnauthorizedResource::make();

        unlink('storage/' . $attachment->path);
        $attachment->delete();

        return DeletedResource::make();
    }
}
