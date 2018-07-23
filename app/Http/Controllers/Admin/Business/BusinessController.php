<?php

namespace App\Http\Controllers\Admin\Business;

use App\Order;
use App\Contact;
use App\Company;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Hashids\HashidsGenerator;
use App\Http\Requests\Business\UpdateBusinessRequest;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $companies = Company::all();
        $contacts = Contact::all();
        $orders = Order::all();

        return view('admin.businesses.index', compact('companies', 'contacts', 'orders'));
    }

    public function store(StoreBusinessRequest $request)
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

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        $business->name = $request->name;
        $business->description = $request->description;
        $business->user_id = $request->user_id;
        $business->contact_id = $request->contact_id;
        $business->company_id = $request->company_id;
        $business->folder_color = $request->folder_color;

        $business->save();

        return response($business, 200);
    }

    public function destroy(Business $business)
    {
        $business->delete();

        return response(null, 204);
    }
}
