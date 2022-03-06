<?php

namespace App\Modules\Sonet\Requests;

class StoreContributorRequest extends SonetRequest
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
