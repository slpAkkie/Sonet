<?php

namespace App\Http\Requests;

class StoreCommentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'body' => 'required',
        ];
    }
}
