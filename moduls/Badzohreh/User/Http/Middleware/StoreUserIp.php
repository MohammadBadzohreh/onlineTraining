<?php

namespace Badzohreh\User\Http\Middleware;

use Closure;

class StoreUserIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->ip != $request->ip()) {
            auth()->user()->ip = $request->ip();
            auth()->user()->save();
        }
        return $next($request);
    }
}
