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
        $orders = Order::withTrashed()->with(['business', 'contact', 'user'])->get()->sortBy('created_at');

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        Order::onlyTrashed()->where('id', $order)->restore();

        return redirect()->route('orders');
    }
}
