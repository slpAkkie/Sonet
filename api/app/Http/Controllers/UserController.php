<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show info about authorized user
     *
     * @return UserResource
     */
    public function show(): UserResource
    {
        return UserResource::make(Auth::user());
    }
}
