<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\DeletedResource;
use App\Http\Resources\Exceptions\UnauthorizedResource;
use App\Models\Comment;
use App\Models\Note;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{

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

        return CommentResource::collection($note->comments()->orderByDesc('created_at')->get());
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
