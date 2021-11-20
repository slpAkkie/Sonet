<?php

namespace App\Http\Requests;

final class StoreNoteRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'               => 'required|string',
            'body'                => 'required|string',
            'category_id'         => 'nullable|exists:categories,id',
            'folder_id'           => 'nullable|exists:folders,id',
            'attachments'         => 'nullable|array',
            'attachments.*'       => 'file',
        ];
    }
}
