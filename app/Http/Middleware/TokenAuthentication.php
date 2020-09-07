<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class TokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        static::authenticate($request);

        return $next($request);
    }

    public static function authenticate(Request $request)
    {
        $providedToken = session('bar_area_token', $request->input('token'));

        if (strcmp($providedToken, static::token()) !== 0) {
            throw new UnauthorizedHttpException('You do not have access to this area.');
        }

        session(['bar_area_token' => $providedToken]);
    }

    public abstract static function token(): String;
}
