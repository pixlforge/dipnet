<?php

namespace Dipnet\Http\Middleware;

use Closure;

class UserAccountCompanyInfo
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
        if (auth()->user()->isNotSolo() && auth()->user()->company_id === null) {
            return redirect()->route('account.company');
        }

        return $next($request);
    }
}
