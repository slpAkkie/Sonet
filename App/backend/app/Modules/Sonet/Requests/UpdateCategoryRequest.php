<?php

namespace App\Modules\Sonet\Requests;

class UpdateCategoryRequest extends SonetRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|min:1',
            'color' => 'nullable|string|size:7|regex:/^#[\da-fA-f]{6}$/',
        ];
    }
}
