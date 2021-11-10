<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Resources\CommonResource;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index() {
        return NoteResource::collection(Auth::user()->notes);
    }

    public function show(GetNoteRequest $request, Note $note) {
        return NoteResource::make($note);
    }

    public function store(StoreNoteRequest $request) {
        $note = new Note($request->all());
        $note->save();

        if ($request->get('attachments')) $note->addAttachments($request->get('attachments'));

        return NoteResource::make($note);
    }

    public function destroy(Note $note) {
        $note->delete();
        return CommonResource::make([
            'message' => 'Deleted'
        ]);
    }
}
