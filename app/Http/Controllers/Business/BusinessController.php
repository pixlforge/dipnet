<?php

namespace App\Http\Controllers\Business;

use App\Order;
use App\Comment;
use App\Company;
use App\Contact;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Requests\Business\UpdateBusinessRequest;

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

        if (auth()->user()->isAdmin()) {
            $companies = Company::orderBy('name')->get();
            $contacts = Contact::orderBy('name')->get();
        } elseif (auth()->user()->isNotSolo()) {
            $businessIds = [];
            foreach (auth()->user()->company->business as $business) {
                array_push($businessIds, $business->id);
            }
            $orders = Order::whereIn('business_id', $businessIds)->get();

            $contacts = Contact::where('company_id', auth()->user()->company->id)
                ->orderBy('name')
                ->get();
        } elseif (auth()->user()->isSolo()) {
            $contacts = Contact::where('user_id', auth()->id())
                ->orderBy('name')
                ->get();
        }

        return view('businesses.index', [
            'companies' => $companies,
            'contacts' => $contacts,
            'orders' => $orders
        ]);
    }

    public function store(StoreBusinessRequest $request)
    {
        $business = new Business;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->user_id = auth()->id();
        $business->company_id = $request->company_id;
        $business->contact_id = $request->contact_id;

        if ($request->reference) {
            $business->reference = $request->reference;
        } else {
            $business->reference = date('Ymd') . '-' . substr(str_slug(auth()->user()->company->name), 0, 8) . '-bus-' . str_random(5);
        }

        if ($request->folder_color) {
            $business->folder_color = $request->folder_color;
        } else {
            $business->folder_color = array_random(['red', 'orange', 'purple', 'blue']);
        }

        $business->save();

        // if ($request->has('setDefault') && auth()->user()->isNotSolo()) {
        //     $company = Company::find($request->company_id);
        //     $company->business_id = $business->id;
        //     $company->save();
        // }

        // $this->setCompanyDefaultBusiness($business);

        $business = $business->with('company', 'contact')->find($business->id);

        return response($business, 200);
    }

    public function show(Business $business)
    {
        $this->authorize('view', $business);

        if (auth()->user()->isAdmin()) {
            $contacts = Contact::orderBy('name')
                ->latest()
                ->get();
        } elseif (auth()->user()->isNotAdmin() && auth()->user()->isNotSolo()) {
            $contacts = Contact::where('company_id', auth()->user()->company_id)
                ->orderBy('name')
                ->latest()
                ->get();
        } else {
            $contacts = Contact::where('user_id', auth()->id())
                ->orderBy('name')
                ->latest()
                ->get();
        }

        $orders = Order::with('user')
            ->where('business_id', $business->id)
            ->latest()
            ->get();

        $comments = Comment::with('user', 'user.avatar')
            ->where('business_id', $business->id)
            ->latest()
            ->get();

        return view('businesses.show', [
            'business' => $business,
            'contacts' => $contacts,
            'orders' => $orders,
            'comments' => $comments
        ]);
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        $business->name = $request->name;
        $business->reference = $request->reference;
        $business->description = $request->description;
        $business->company_id = $request->company_id;
        $business->contact_id = $request->contact_id;
        $business->folder_color = $request->folder_color;
        $business->save();

        return response($business, 200);
    }

    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);

        $business->delete();

        return response(null, 204);
    }

    protected function setCompanyDefaultBusiness($business)
    {
        if (auth()->user()->isNotAdmin() && auth()->user()->isPartOfACompany()) {
            if (auth()->user()->company->hasNoDefaultBusiness()) {
                $company = Company::where('id', auth()->user()->company->id)->firstOrFail();
                $company->business_id = $business->id;
                $company->save();
            }
        }
    }
}
