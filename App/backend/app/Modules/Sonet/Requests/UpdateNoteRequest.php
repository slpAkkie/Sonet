<?php

namespace App\Modules\Sonet\Requests;

final class UpdateNoteRequest extends SonetRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'               => 'string|min:1',
            'body'                => 'nullable|string',
            'category_id'         => 'nullable|exists:categories,id',
            'folder_id'           => 'nullable|exists:folders,id',
            'attachments'         => 'nullable|array',
            'attachments.*'       => 'file',
        ];
    }
}
