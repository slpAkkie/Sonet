<?php

namespace App\Modules\Sonet\Resources;

use App\Modules\Sonet\Models\User;
use App\Modules\Sonet\Models\UserToken;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin UserToken
 */
class AuthLogResource extends \App\Http\Resources\CommonResource
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
