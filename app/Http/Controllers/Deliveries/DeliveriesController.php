<?php

namespace App\Http\Controllers\Deliveries;

use App\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;

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
        $this->authorize('view', Delivery::class);

        $deliveries = Delivery::with('order', 'contact')
            ->orderBy('created_at')
            ->get()
            ->toJson();

        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryRequest $request)
    {
        $this->authorize('create', Delivery::class);

        Delivery::create([
            'reference' => $request->reference,
            'order_id' => $request->order_id,
            'contact_id' => $request->contact_id,
            'internal_comment' => $request->internal_comment
        ]);

        return redirect()->route('deliveries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        $this->authorize('view', $delivery);

        return view('deliveries.show');
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
        $this->authorize('update', $delivery);

        $delivery->update([
            'order_id' => $request->order_id,
            'contact_id' => $request->contact_id,
            'internal_comment' => $request->internal_comment
        ]);

        return redirect()->route('deliveries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        $this->authorize('delete', $delivery);

        $delivery->delete();

        return redirect()->route('deliveries.index');
    }
}