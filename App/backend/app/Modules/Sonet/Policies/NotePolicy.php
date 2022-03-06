<?php

namespace App\Modules\Sonet\Policies;

use App\Modules\Sonet\Models\AccessLevel;
use App\Modules\Sonet\Models\Note;
use App\Modules\Sonet\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the note.
     *
     * @param User $user
     * @param Note $note
     * @return bool
     */
    public function view(User $user, Note $note): bool
    {
        $access = $user->id === $note->user_id;

        if ($user->contributorIn()->wherePivot('note_id', $note->id)->first()) $access = true;

        return $access;
    }

    /**
     * Determine whether the user can update the note.
     *
     * @param User $user
     * @param Note $note
     * @return bool
     */
    public function update(User $user, Note $note): bool
    {
        $access = $user->id === $note->user_id;

        $sharedNote = $user->contributorIn()->wherePivot('note_id', $note->id)->first();

        if ($sharedNote && !AccessLevel::isReadOnly($sharedNote->pivot->access_level_id)) $access = true;

        return $access;
    }

    /**
     * Determine whether the user can delete the note.
     *
     * @param User $user
     * @param Note $note
     * @return bool
     */
    public function delete(User $user, Note $note): bool
    {
        $access = $user->id === $note->user_id;

        $sharedNote = $user->contributorIn()->wherePivot('note_id', $note->id)->first();

        if ($sharedNote && !AccessLevel::isReadOnly($sharedNote->pivot->access_level_id)) $access = true;

        return $access;
    }
}
