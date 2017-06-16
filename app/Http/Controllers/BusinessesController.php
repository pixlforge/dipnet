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
        Business::onlyTrashed()->where('id', $business)->restore();

        return redirect()->route('businesses');
    }
}
