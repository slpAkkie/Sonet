<?php

namespace App\Modules\Sonet\Requests;

final class StoreFolderRequest extends SonetRequest
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
