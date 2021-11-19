<?php

namespace App\Http\Requests;

final class LoginRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'login'    => 'required',
            'password' => 'required'
        ];
    }
}
