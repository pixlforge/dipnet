<?php

namespace App\Http\Controllers\Admin\Business;

use App\User;
use App\Order;
use App\Contact;
use App\Company;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Hashids\HashidsGenerator;
use App\Http\Requests\Business\StoreAdminBusinessRequest;
use App\Http\Requests\Business\UpdateAdminBusinessRequest;

class BusinessController extends Controller
{
    /**
     * BusinessController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a list of all businesses.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::all();
        $contacts = Contact::all();
        $orders = Order::all();
        $users = User::onlyUsers()->get(['id', 'username', 'email', 'is_solo', 'company_id']);

        return view('admin.businesses.index', compact('companies', 'contacts', 'orders', 'users'));
    }

    /**
     * Store a new business.
     *
     * @param StoreAdminBusinessRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreAdminBusinessRequest $request)
    {
        $business = new Business;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->user_id = $request->user_id;
        $business->contact_id = $request->contact_id;
        $business->company_id = $request->company_id;

        if ($request->has('folder_color')) {
            $business->folder_color = $request->folder_color;
        } else {
            $business->folder_color = array_random(['red', 'orange', 'purple', 'blue']);
        }

        $business->save();
        
        $business->reference = HashidsGenerator::generateFor($business->id, 'businesses');

        $business->save();

        $business = $business->load('company', 'contact');

        return response($business, 200);
    }

    /**
     * Update an existing business.
     *
     * @param UpdateAdminBusinessRequest $request
     * @param Business $business
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateAdminBusinessRequest $request, Business $business)
    {
        $business->name = $request->name;
        $business->description = $request->description;
        $business->user_id = $request->user_id;

        if ($business->company) {
            if ($business->company->business_id === $business->id) {
                $business->company->business_id = null;
                $business->company->save();
            }
        }

        if ($business->contact) {
            $business->contact_id = null;
        }

        $business->contact_id = $request->contact_id;
        $business->company_id = $request->company_id;
        $business->folder_color = $request->folder_color;

        $business->save();

        $business->load('company', 'contact');

        return response($business, 200);
    }

    /**
     * Delete an existing business.
     *
     * @param Business $business
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Business $business)
    {
        if ($business->belongsToACompany()) {
            $business->company->business_id = null;
            $business->company->save();
        }

        $business->delete();

        return response(null, 204);
    }
}
