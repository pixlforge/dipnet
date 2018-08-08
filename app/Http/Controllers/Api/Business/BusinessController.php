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
        $this->middleware('auth');
    }

    /**
     * Fetch businesses.
     *
     * @param string $sort
     * @return BusinessesCollection
     */
    public function index($sort = 'name')
    {
        if (auth()->user()->isAdmin()) {
            if ($sort === 'created_at') {
                return new BusinessesCollection(
                    Business::with('company', 'contact')
                        ->orderBy($sort, 'desc')
                        ->paginate(25)
                );
            } else {
                return new BusinessesCollection(
                    Business::with('company', 'contact')
                        ->orderBy($sort)
                        ->paginate(25)
                );
            }
        } elseif (auth()->user()->isNotSolo()) {
            if ($sort === 'created_at') {
                return new BusinessesCollection(
                    Business::where('company_id', auth()->user()->company->id)
                        ->with('company', 'contact')
                        ->orderBy($sort, 'desc')
                        ->paginate(25)
                );
            } else {
                return new BusinessesCollection(
                    Business::where('company_id', auth()->user()->company->id)
                        ->with('company', 'contact')
                        ->orderBy($sort)
                        ->paginate(25)
                );
            }
        } elseif (auth()->user()->isSolo()) {
            if ($sort === 'created_at') {
                return new BusinessesCollection(
                    Business::where('user_id', auth()->id())
                        ->with('contact')
                        ->orderBy($sort, 'desc')
                        ->paginate(25)
                );
            } else {
                return new BusinessesCollection(
                    Business::where('user_id', auth()->id())
                        ->with('contact')
                        ->orderBy($sort)
                        ->paginate(25)
                );
            }
        }
    }
}
