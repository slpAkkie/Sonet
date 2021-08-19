<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenAuth
{
    /**
     * Handle an incoming request.
     * Check if token is present
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws UnauthorizedException
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User|null $user */
        $user = User::findByToken($request->bearerToken());
        if (!$user) throw new UnauthorizedException();

        Auth::login($user);
        return $next($request);
    }
}
