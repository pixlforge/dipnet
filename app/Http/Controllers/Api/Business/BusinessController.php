<?php

namespace Dipnet\Http\Controllers\Api\Business;

use Dipnet\Business;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\BusinessesCollection;

class BusinessController extends Controller
{
    /**
     * BusinessController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return BusinessesCollection
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return new BusinessesCollection(
                Business::with('company', 'contact')
                    ->orderBy('name')
                    ->paginate(25)
            );
        } else {
            return new BusinessesCollection(
                Business::where('company_id', auth()->user()->company->id)
                    ->with('company', 'contact')
                    ->orderBy('name')
                    ->paginate(25)
            );
        }
    }
}
