<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\DeletedResource;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    /**
     * Show all user's own notes.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();

        return NoteResource::collection($user->notesOrderedByUpdate());
    }

    /**
     * Show all user's own notes.
     *
     * @return AnonymousResourceCollection
     */
    public function indexShared(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();

        return NoteResource::collection($user->contributorInOrderedByUpdate());
    }

    /**
     * Show a specific note.
     *
     * @param Note $note
     * @return NoteResource
     */
    public function show(Note $note): NoteResource
    {
        Gate::authorize('view-note', $note);

        $note->setResourceWithAttachments();

        return NoteResource::make($note);
    }

    /**
     * Store new note.
     *
     * @param StoreNoteRequest $request
     * @return NoteResource
     */
    public function store(StoreNoteRequest $request): NoteResource
    {
        $note = Note::new($request->all());
        $note->save();

        return NoteResource::make($note);
    }

    /**
     * Update the note.
     *
     * @param UpdateNoteRequest $request
     * @param Note $note
     * @return NoteResource
     */
    public function update(UpdateNoteRequest $request, Note $note): NoteResource
    {
        Gate::authorize('update-note', $note);

        $note->update($request->all());
        // TODO: Update attachments.

        return NoteResource::make($note);
    }

    /**
     * Delete note.
     *
     * @param Note $note
     * @return DeletedResource
     */
    public function destroy(Note $note): DeletedResource
    {
        Gate::authorize('delete-note', $note);

        $note->delete();

        return DeletedResource::make();
    }
}
