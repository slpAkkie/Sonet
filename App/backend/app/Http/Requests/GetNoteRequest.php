<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class GetNoteRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->note->user_id !== Auth::id()) return false;

        $this->note->setWithFullResource();
        return true;
    }
}
