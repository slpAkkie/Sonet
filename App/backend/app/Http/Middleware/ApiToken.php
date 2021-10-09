<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiTokenAuthorizationException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws ApiTokenAuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) throw new ApiTokenAuthorizationException();

        Auth::login(User::findByToken($request->bearerToken()));
        return $next($request);
    }
}
