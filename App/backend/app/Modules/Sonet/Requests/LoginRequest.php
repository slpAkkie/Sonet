<?php

namespace App\Modules\Sonet\Requests;

final class LoginRequest extends SonetRequest
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
            'password' => 'required',
        ];
    }
}
