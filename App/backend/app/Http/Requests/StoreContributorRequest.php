<?php

namespace App\Http\Requests;

class StoreContributorRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|exists:users,email',
            'access_level_id' => 'required|exists:access_levels,id',
        ];
    }
}
