<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreContributorRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ContributorResource;
use App\Http\Resources\DeletedResource;
use App\Http\Resources\Exceptions\UnauthorizedResource;
use App\Http\Resources\NoteResource;
use App\Models\AccessLevel;
use App\Models\Comment;
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

        $note->setFullResource();

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

    /**
     * Show all note contributors
     *
     * @param Note $note
     * @return AnonymousResourceCollection
     */
    public function indexContributors(Note $note): AnonymousResourceCollection
    {
        return ContributorResource::collection($note->contributors);
    }

    /**
     * Add contributor to the note (Or also change it's access level)
     *
     * @param StoreContributorRequest $request
     * @param Note $note
     * @return ContributorResource
     */
    public function addContributor(StoreContributorRequest $request, Note $note): ContributorResource
    {
        $contributor = User::findByEmail($request->get('email'));

        $note->contributors()->syncWithoutDetaching([
            $contributor->id => [
                'access_level_id' => $request->get('access_level_id'),
            ],
        ]);

        $contributor->setAccessLevel(AccessLevel::find($request->get('access_level_id')));

        return ContributorResource::make($contributor);
    }

    /**
     * Delete contributor from note
     *
     * @param Note $note
     * @param $user_id
     * @return DeletedResource
     */
    public function destroyContributor(Note $note, $user_id): DeletedResource
    {
        $note->contributors()->detach($user_id);

        return DeletedResource::make();
    }

    /**
     * Create new comment for the note
     *
     * @param StoreCommentRequest $request
     * @param Note $note
     * @return CommentResource|UnauthorizedResource
     */
    public function addComment(StoreCommentRequest $request, Note $note)
    {
        if (!Gate::check('create-comment', $note)) return UnauthorizedResource::make();

        return CommentResource::make($note->addComment($request->get('body')));
    }

    /**
     * Get all comments
     *
     * @param Note $note
     * @return UnauthorizedResource|AnonymousResourceCollection
     */
    public function indexComments(Note $note)
    {
        if (!Gate::check('view-note', $note)) return UnauthorizedResource::make();

        return CommentResource::collection($note->comments);
    }

    /**
     * Remove comment
     *
     * @param Note $note
     * @param Comment $comment
     * @return DeletedResource|UnauthorizedResource
     */
    public function destroyComment(Note $note, Comment $comment)
    {
        if (!Gate::check('delete-comment', [$note, $comment])) return UnauthorizedResource::make();

        $comment->delete();

        return DeletedResource::make();
    }
}
