<?php

namespace App\Http\Middleware;

use App\Exceptions\NoApiTokenProvidedException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class ApiToken
{
    /**
     * Check if bearer api token was sent
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
