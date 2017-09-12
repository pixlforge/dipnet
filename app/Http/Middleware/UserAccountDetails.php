<?php

namespace App\Http\Middleware;

use Closure;

class UserAccountDetails
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
        if (auth()->user()->wasInvited() && auth()->user()->hasConfirmationToken()) {
            return redirect()->route('account');
        }
        return $next($request);
    }
}
