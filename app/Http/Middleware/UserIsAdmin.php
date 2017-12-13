<?php

namespace Dipnet\Http\Middleware;

use Closure;

class UserIsAdmin
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
        if (auth()->check() && auth()->user()->isNotAdmin()) {
            abort(403, "Vous n'êtes pas autorisé à accéder à cette ressource.");
        } else if (!auth()->check()) {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
