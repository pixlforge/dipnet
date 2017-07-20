<?php

namespace App\Http\Controllers;

use App\Business;
use App\Contact;
use App\Http\Requests\OrderRequest;
use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * OrdersController constructor.
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
        if (auth()->user()->contact_id === null) {
            return redirect()->route('contactDetails');
        }

        if(auth()->user()->company_id === null) {
            return redirect()->route('companyDetails');
        }

        $this->authorize('view', Order::class);

        if (auth()->user()->role == 'administrateur') {
            $orders = Order::withTrashed()->with(['business', 'contact', 'user'])->get()->sortBy('created_at');
        } else {
            $orders = Order::where('user_id', auth()->user()->id)->with(['business', 'contact', 'user'])->get()->sortBy('created_at');
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $this->authorize('create', Order::class);

        $businesses = Business::all()->sortBy('company.name');

        $contacts = Contact::all()->sortBy('company.name');

        return view('orders.create', compact(['businesses', 'contacts']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $this->authorize('create', Order::class);

        Order::create([
            'reference' => request('reference'),
            'status' => request('status'),
            'business_id' => request('business_id'),
            'contact_id' => request('contact_id'),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('orders');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $this->authorize('update', $order);

        $businesses = Business::all()->sortBy('company.name');

        $contacts = Contact::all()->sortBy('company.name');

        return view('orders.edit', compact(['businesses', 'contacts', 'order']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $order->update([
            'reference' => request('reference'),
            'status' => request('status'),
            'business_id' => request('business_id'),
            'contact_id' => request('contact_id')
        ]);

        return redirect()->route('orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()->route('orders');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($order)
    {
        $this->authorize('restore', Order::class);

        Order::onlyTrashed()->where('id', $order)->restore();

        return redirect()->route('orders');
    }
}
