<?php

namespace App\Observers;

use App\Models\Note;

class NoteObserver
{
    /**
     * Handle the Note "saved" event.
     *
     * @param Note $note
     * @return void
     */
    public function saved(Note $note)
    {
        $note->storeAttachments();
    }
}
