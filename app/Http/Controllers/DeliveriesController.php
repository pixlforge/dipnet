<?php

namespace App\Http\Controllers;

use App\Order;
use App\Contact;
use App\Delivery;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    /**
     * DeliveriesController constructor.
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
        $deliveries = Delivery::withTrashed()->with('order', 'contact')->get()->sortBy('created_at');
        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = Order::all();
        $contacts = Contact::all()->sortBy('company.name');

        return view('deliveries.create', compact(['orders', 'contacts']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryRequest $request)
    {
        Delivery::create([
            'order_id' => request('order_id'),
            'contact_id' => request('contact_id'),
            'internal_comment' => request('internal_comment')
        ]);

        return redirect()->route('deliveries');
    }

    /**
     * Display the specified resource.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        return view('deliveries.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        $orders = Order::all();
        $contacts = Contact::all();

        return view('deliveries.edit', compact(['delivery', 'orders', 'contacts']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeliveryRequest|Request $request
     * @param Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        $delivery->update([
            'order_id' => request('order_id'),
            'contact_id' => request('contact_id'),
            'internal_comment' => request('internal_comment')
        ]);

        return redirect()->route('deliveries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return redirect()->route('deliveries');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $delivery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($delivery)
    {
        Delivery::onlyTrashed()->where('id', $delivery)->restore();
        return redirect()->route('deliveries');
    }
}
