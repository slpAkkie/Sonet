<?php

namespace App\Http\Middleware;

use App\Exceptions\NoApiTokenProvidedException;
use App\Modules\Sonet\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class AuthenticateWithToken
{
    /**
     * Check if bearer api token was sent.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws NoApiTokenProvidedException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) throw new NoApiTokenProvidedException();

        Auth::login(User::findByTokenOrFail($request->bearerToken()));
        return $next($request);
    }
}
