<?php

namespace App\Http\Middleware;

use Closure;

class CompanyHasDefaultBusiness
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
        if (auth()->user()->isNotAdmin() &&
        auth()->user()->isPartOfACompany() &&
        auth()->user()->company->hasNoDefaultBusiness()) {
            return redirect(route('companies.default.business.edit'));
        }

        return $next($request);
    }
}
