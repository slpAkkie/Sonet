<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin UserToken
 */
class AuthLogResource extends CommonResource
{
    public function toArray($request)
    {
        /** @var User $user */
        $user = Auth::user();
        return [
            'id' => $this->id,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'current' => $this->when($this->id === $user->getCurrentToken()->id, true)
        ];
    }
}
