<?php

namespace App\Http\Controllers\Api\Business;

use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessesCollection;

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
        } else if (auth()->user()->isNotSolo()) {
            return new BusinessesCollection(
                Business::where('company_id', auth()->user()->company->id)
                    ->with('company', 'contact')
                    ->orderBy('name')
                    ->paginate(25)
            );
        } else {
            return new BusinessesCollection(
                Business::where('user_id', auth()->id())
                    ->with('contact')
                    ->orderBy('name')
                    ->paginate(25)
            );
        }
    }
}
