<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Business;
use App\Http\Requests\BusinessRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class BusinessesController extends Controller
{
    /**
     * BusinessesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Businesses.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Business::class);

        if (auth()->user()->role === 'administrateur') {
            $businesses = Business::with('company', 'contact')
                ->orderBy('name')
                ->get()
                ->toJson();

            $companies = Company::with('contact')
                ->orderBy('name')
                ->get()
                ->toJson();
        } else {
            $businesses = Business::with('company', 'contact')
                ->orderBy('name')
                ->get()
                ->toJson();
        }

        return view('businesses.index', compact([
            'businesses', 'companies'
        ]));
    }

    /**
     * Show the view responsible of the creation of a new Business
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Business::class);

        $companies = Company::all()
            ->sortBy('name');

        $contacts = Contact::all()
            ->sortBy('name')
            ->sortBy('company.name');

        return view('businesses.create', compact([
            'companies', 'contacts'
        ]));
    }

    /**
     * Persist a new Business model.
     *
     * @param BusinessRequest $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function store(BusinessRequest $request)
    {
        $this->authorize('create', Business::class);

        if (auth()->user()->role == 'administrateur') {
            $business = Business::create([
                'name' => request('name'),
                'reference' => request('reference'),
                'description' => request('description'),
                'company_id' => request('company_id'),
                'contact_id' => request('contact_id'),
                'created_by_username' => auth()->user()->username
            ]);
        } else {
            $business = 'TODO';
        }

        // Process the Axios http request and return the model's id.
        if (request()->wantsJson()) {
            return $business->id;
        }

        return redirect()->route('businesses');
    }

    /**
     * Display the specified Business.
     *
     * @param Business $business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Business $business)
    {
        $this->authorize('view', $business);

        return view('businesses.show', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BusinessRequest $request
     * @param Business $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BusinessRequest $request, Business $business)
    {
        $this->authorize('update', $business);

        $business->update([
            'name' => request('name'),
            'reference' => request('reference'),
            'description' => request('description'),
            'company_id' => request('company_id'),
            'contact_id' => request('contact_id')
        ]);

        return redirect()
            ->route('businesses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);

        $business->delete();

        return redirect()->route('businesses');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($business)
    {
        $this->authorize('restore', Business::class);

        Business::onlyTrashed()->where('id', $business)->restore();

        return redirect()->route('businesses');
    }
}
