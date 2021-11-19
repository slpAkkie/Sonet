<?php

namespace App\Http\Requests;

final class RegisterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'login'      => 'required|unique:users,login',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed'
        ];
    }
}
