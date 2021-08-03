<?php

namespace App\Http\Requests;

class StoreNoteRequest extends ApiRequest
{
    public function messages()
    {
        return [
            'title.required' => 'Вы забыли указать название'
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }
}
