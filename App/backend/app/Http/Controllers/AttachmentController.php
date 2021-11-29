<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\DeletedResource;
use App\Http\Resources\Exceptions\UnauthorizedResource;
use App\Models\Attachment;
use App\Models\Note;
use Illuminate\Support\Facades\Gate;

class AttachmentController extends Controller
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
