<?php

namespace App\Http\Controllers\Business;

use App\Order;
use App\Comment;
use App\Contact;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Hashids\HashidsGenerator;
use App\Http\Requests\Business\StoreUserBusinessRequest;
use App\Http\Requests\Business\UpdateUserBusinessRequest;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = collect();
        $contacts = collect();
        $orders = collect();

        if (auth()->user()->isPartOfACompany()) {
            $businessIds = [];
            foreach (auth()->user()->company->business as $business) {
                array_push($businessIds, $business->id);
            }
            $orders = Order::whereIn('business_id', $businessIds)->get();
            $contacts = Contact::where('company_id', auth()->user()->company->id)->orderBy('name')->get();
        } elseif (auth()->user()->isSolo()) {
            $contacts = Contact::where('user_id', auth()->id())->orderBy('name')->get();
        }

        return view('businesses.index', compact('businesses', 'contacts', 'companies', 'orders'));
    }

    public function store(StoreUserBusinessRequest $request)
    {
        $business = new Business;
        $business->name = $request->name;
        $business->description = $request->description;

        if (auth()->user()->isPartOfACompany()) {
            $business->user_id = null;
            $business->company_id = auth()->user()->company->id;
        } elseif (auth()->user()->isSolo()) {
            $business->user_id = auth()->id();
            $business->company_id = null;
        }

        $business->contact_id = $request->contact_id;

        if ($request->has('folder_color')) {
            $business->folder_color = $request->folder_color;
        } else {
            $business->folder_color = array_random(['red', 'orange', 'purple', 'blue']);
        }
        $business->save();
        
        $business->reference = HashidsGenerator::generateFor($business->id, 'businesses');
        $business->save();
    
        if (auth()->user()->isPartOfACompany()) {
            $business = $business->with('company', 'contact')->find($business->id);
        } elseif (auth()->user()->isSolo()) {
            $business = $business->with('contact')->find($business->id);
        }

        return response($business, 200);
    }

    public function show(Business $business)
    {
        $this->authorize('view', $business);

        if (auth()->user()->isPartOfACompany()) {
            $contacts = Contact::where('company_id', auth()->user()->company_id)->orderBy('name')->latest()->get();
        } elseif (auth()->user()->isSolo()) {
            $contacts = Contact::where('user_id', auth()->id())->orderBy('name')->latest()->get();
        }

        $orders = Order::with('user')->where('business_id', $business->id)->latest()->get();
        $comments = Comment::with('user', 'user.avatar')->where('business_id', $business->id)->latest()->get();

        return view('businesses.show', compact('business', 'contacts', 'orders', 'comments'));
    }

    public function update(UpdateUserBusinessRequest $request, Business $business)
    {
        $this->authorize('update', $business);
        
        $business->name = $request->name;
        $business->description = $request->description;
        $business->contact_id = $request->contact_id;
        $business->folder_color = $request->folder_color;
        $business->save();

        return response($business, 200);
    }
}
