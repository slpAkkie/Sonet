<?php

namespace App\Http\Requests;

class StoreNoteRequest extends ApiRequest
{
    public function messages()
    {
        return [
            'title.required' => 'Вы забыли указать название',
            'meta.array' => 'Мета данные должны быть массивом',
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'meta' => 'nullable|array',
        ];
    }
}
