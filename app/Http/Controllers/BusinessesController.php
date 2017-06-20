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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Business::class);

        $businesses = Business::withTrashed()
            ->with('company', 'contact')
            ->get()
            ->sortBy('name');

        return view('businesses.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param BusinessRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessRequest $request)
    {
        $this->authorize('create', Business::class);

        Business::create([
            'name' => request('name'),
            'reference' => request('reference'),
            'description' => request('description'),
            'company_id' => request('company_id'),
            'contact_id' => request('contact_id'),
            'created_by_username' => auth()->user()->username
        ]);

        return redirect()->route('businesses');
    }

    /**
     * Display the specified resource.
     *
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        $this->authorize('view', $business);

        return view('businesses.show', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        $this->authorize('update', $business);

        $companies = Company::all()
            ->sortBy('name');

        $contacts = Contact::all()
            ->sortBy('name')
            ->sortBy('company.name');

        return view('businesses.edit', compact([
            'business', 'companies', 'contacts'
        ]));
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
