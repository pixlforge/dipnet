<?php

namespace App\Http\Middleware;

use Closure;

class UserRegistrationIsComplete
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
        if (auth()->user()->contact_id === null) {
            return redirect()->route('contactDetails');
        }

        if(auth()->user()->company_id === null) {
            return redirect()->route('companyDetails');
        }

        return $next($request);
    }
}
