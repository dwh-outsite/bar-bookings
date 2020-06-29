<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
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
        $providedToken = session('bar_area_token', $request->input('token'));

        if (strcmp($providedToken, $this->token()) !== 0) {
            throw new UnauthorizedHttpException('You do not have access to this area.');
        }

        session(['bar_area_token' => $providedToken]);

        return $next($request);
    }

    public abstract function token(): String;
}
