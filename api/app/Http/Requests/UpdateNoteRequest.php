<?php

namespace App\Http\Requests;

class UpdateNoteRequest extends ApiRequest
{
    public function messages()
    {
        return [
            'meta.array' => 'Meta-атрибуты должны быть массивом'
        ];
    }

    public function rules()
    {
        return [
            'meta' => 'nullable|array'
        ];
    }
}
