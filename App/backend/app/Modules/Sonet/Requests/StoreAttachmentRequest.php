<?php

namespace App\Modules\Sonet\Requests;

class StoreAttachmentRequest extends SonetRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'attachment' => 'required|file',
        ];
    }
}
