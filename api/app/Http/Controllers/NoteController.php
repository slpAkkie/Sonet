<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Get the user's own notes
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function own(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $notes = Note::whereHas('author', function ($query) {
            $query->where('id', Auth::id());
        })->get();

        return NoteResource::collection($notes);
    }
    /**
     * Get the user's notes shared with him
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function shared(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $notes = Note::whereHas('metas', function ($query) {
            $query->where('meta_key', 'user_id')->where('meta_value', Auth::id());
        })->get();

        return NoteResource::collection($notes);
    }

    /**
     * Create new note for the user
     *
     * @param StoreNoteRequest $request
     * @return NoteResource
     */
    public function create(StoreNoteRequest $request): NoteResource
    {
        return NoteResource::make(Note::createFrom($request->all()), 201);
    }

    /**
     * Update the user's specified note
     *
     * @param UpdateNoteRequest $request
     * @param Note $note
     * @return NoteResource
     */
    public function update(UpdateNoteRequest $request, Note $note): NoteResource
    {
        return NoteResource::make($note->updateFrom($request->all()));
    }
}
