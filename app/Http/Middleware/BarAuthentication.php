<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class BarAuthentication
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

        if (strcmp($providedToken, config('app.bar_area_token')) !== 0) {
            throw new UnauthorizedHttpException('You do not have access to this area.');
        }

        session(['bar_area_token' => $providedToken]);

        return $next($request);
    }
}
