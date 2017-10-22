<?php

namespace App\Http\Controllers\Business;

use App\Company;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Requests\Business\UpdateBusinessRequest;

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
     * Display a listing of all Businesses.
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
     * Store a Business.
     *
     * @param StoreBusinessRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreBusinessRequest $request)
    {
        $business = Business::create([
            'name' => $request->name,
            'reference' => $request->reference,
            'description' => $request->description,
            'company_id' => $request->company_id,
            'contact_id' => $request->contact_id,
            'created_by_username' => auth()->user()->username
        ]);

        $business = $business->with('company', 'contact')->find($business->id);

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
     * Update the Business.
     *
     * @param UpdateBusinessRequest $request
     * @param Business $business
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateBusinessRequest $request, Business $business)
    {
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
