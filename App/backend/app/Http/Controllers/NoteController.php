<?php

namespace App\Http\Controllers;

use App\Exceptions\RecordDoesntExistException;
use App\Http\Requests\ShowNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Resources\CommonResource;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Show all user's own notes
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();

        return NoteResource::collection($user->notes()->orderBy('update_at')->get());
    }

    /**
     * Show a specific user note
     *
     * @param ShowNoteRequest $request
     * @param Note $note
     * @return NoteResource
     */
    public function show(ShowNoteRequest $request, Note $note): NoteResource
    {
        return NoteResource::make($note);
    }

    /**
     * Store new user's note
     *
     * @param StoreNoteRequest $request
     * @return NoteResource
     * @throws RecordDoesntExistException
     */
    public function store(StoreNoteRequest $request): NoteResource
    {
        $note = new Note($request->all());
        $note->save();

        if ($request->get('attachments')) $note->addAttachments($request->get('attachments'));

        return NoteResource::make($note);
    }

    /**
     * Delete user's note
     *
     * @param Note $note
     * @return CommonResource
     */
    public function destroy(Note $note): CommonResource
    {
        $note->delete();

        return CommonResource::make([
            'message' => 'Deleted'
        ]);
    }
}
