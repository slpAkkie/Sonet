<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends ApiRequest
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
