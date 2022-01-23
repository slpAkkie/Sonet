<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create comment for the note.
     *
     * @param User $user
     * @param Note $note
     * @return bool
     */
    public function create(User $user, Note $note): bool
    {
        $access = $user->id === $note->user_id;

        if ($user->contributorIn()->wherePivot('note_id', $note->id)->first()) $access = true;

        return $access;
    }

    /**
     * Determine whether the user can delete comment from the note.
     *
     * @param User $user
     * @param Note $note
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Note $note, Comment $comment): bool
    {
        $access = $user->id === $note->user_id;

        if ($comment->author->id === $user->id) $access = true;

        return $access;
    }
}
