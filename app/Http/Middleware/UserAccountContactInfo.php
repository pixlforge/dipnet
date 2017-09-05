<?php

namespace App\Http\Middleware;

use Closure;

class UserAccountContactInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->contact->name === 'default') {
            return redirect()->route('missingContact');
        }

        return $next($request);
    }
}
