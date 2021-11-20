<?php

namespace App\Http\Requests;

final class StoreFolderRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
        ];
    }
}
