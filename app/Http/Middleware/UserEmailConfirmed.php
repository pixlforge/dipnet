<?php

namespace App\Http\Middleware;

use Closure;

class UserEmailConfirmed
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
        if (! $request->user()->isConfirmed()) {

            if (request()->wantsJson()) {
                return response("Vous devez d'abord confirmer votre adresse e-mail.", 403);
            }

            return redirect(route('profile.index'))
                ->with('flash', "Vous devez d'abord confirmer votre adresse e-mail.")
                ->with('level', 'danger');
        }

        return $next($request);
    }
}
