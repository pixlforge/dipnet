<?php

namespace App\Http\Middleware;

use Closure;

class UserHasAtLeastOneBusiness
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
        if (auth()->user()->isSolo() && auth()->user()->userBusinesses->count() === 0) {
            return redirect(route('businesses.index'))
                ->with('flash', 'Vous devez créer une affaire avant de faire cela.')
                ->with('level', 'danger');
        }

        return $next($request);
    }
}
