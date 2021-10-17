<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNoteRequest;
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
}
