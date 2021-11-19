<?php

namespace App\Http\Requests;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

/**
 * @property Note note
 */
final class ShowNoteRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request
     * Allows only if authenticated user is owner of note
     * Also sets note to be convert into resource with information about attachments
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->note->user_id !== Auth::id()) return false;

        $this->note->setWithAttachments();

        return true;
    }
}
