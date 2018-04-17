<?php

namespace Dipnet\Http\Controllers\Business;

use Dipnet\Order;
use Dipnet\Comment;
use Dipnet\Company;
use Dipnet\Contact;
use Dipnet\Business;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Business\StoreBusinessRequest;
use Dipnet\Http\Requests\Business\UpdateBusinessRequest;

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
        $companies = Company::orderBy('name')->get();
        $contacts = Contact::orderBy('name')->get();

        $orders = collect();

        if (auth()->user()->isNotAdmin()) {
            $businessIds = [];

            foreach (auth()->user()->company->business as $business) {
                array_push($businessIds, $business->id);
            }

            $orders = Order::whereIn('business_id', $businessIds)->get();
        }

        return view('businesses.index', [
            'companies' => $companies,
            'contacts' => $contacts,
            'orders' => $orders
        ]);
    }

    /**
     * Create business page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $company = auth()->user()->company;
        $contacts = Contact::where('company_id', auth()->user()->company_id)->get();

        return view('businesses.create', [
            'company' => $company,
            'contacts' => $contacts
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
        $business = new Business;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->company_id = $request->company_id;
        $business->contact_id = $request->contact_id;
        $business->created_by_username = auth()->user()->username;

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

        if ($request->has('setDefault') && auth()->user()->isNotSolo()) {
            $company = Company::find($request->company_id);
            $company->business_id = $business->id;
            $company->save();
        }

        $business = $business->with('company', 'contact')->find($business->id);

        return response($business, 200);
    }

    /**
     * Display the specified Business.
     *
     * @param Business $business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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

    /**
     * Update the Business.
     *
     * @param UpdateBusinessRequest $request
     * @param Business $business
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Business $business
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);

        $business->delete();

        return response(null, 204);
    }
}
