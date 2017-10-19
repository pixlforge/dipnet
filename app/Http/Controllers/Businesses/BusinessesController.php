<?php

namespace App\Http\Controllers\Businesses;

use App\Company;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessRequest;

class BusinessesController extends Controller
{
    /**
     * BusinessesController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the Businesses.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Business::class);

        $businesses = Business::with('company', 'contact')
            ->orderBy('name')
            ->get()
            ->toJson();

        $companies = Company::with('contact')
            ->orderBy('name')
            ->get()
            ->toJson();

        return view('businesses.index', [
            'businesses' => $businesses,
            'companies' => $companies
        ]);
    }

    /**
     * Persist a new Business model.
     *
     * @param StoreBusinessRequest $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function store(StoreBusinessRequest $request)
    {
        $this->authorize('create', Business::class);

        $business = Business::create([
            'name' => $request->name,
            'reference' => $request->reference,
            'description' => $request->description,
            'company_id' => $request->company_id,
            'contact_id' => $request->contact_id,
            'created_by_username' => auth()->user()->username
        ]);

        $business = $business->with('company', 'contact')->first();

        return response($business, 200);
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
     * @param StoreBusinessRequest $request
     * @param Business $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreBusinessRequest $request, Business $business)
    {
        $this->authorize('update', $business);

        $business->update([
            'name' => $request->name,
            'reference' => $request->reference,
            'description' => $request->description,
            'company_id' => $request->company_id,
            'contact_id' => $request->contact_id
        ]);

        return response($business, 200);
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

        return response(null, 204);
    }
}
