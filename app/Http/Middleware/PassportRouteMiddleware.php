<?php

namespace App\Http\Middleware;

use Closure;

class PassportRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->request->add(['client_id' => config('app.client_id')]);
        $request->request->add(['client_secret' => config('app.client_secret')]);
        $request->request->add(['grant_type' => config('app.grant_type')]);

        return $next($request);
    }
}
