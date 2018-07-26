<?php

namespace App\Http\Controllers\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\StoreDeliveryRequest;
use App\Http\Requests\Delivery\UpdateDeliveryRequest;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('deliveries.index', compact('deliveries'));
    }

    public function store(StoreDeliveryRequest $request)
    {
        $delivery = new Delivery;
        $delivery->reference = date('Ymd') . '-' . substr(str_slug(auth()->user()->company->name), 0, 8) . '-del-' . str_random(5);
        $delivery->order_id = $request->order_id;
        $delivery->save();

        return response($delivery, 200);
    }

    public function update(UpdateDeliveryRequest $request, Delivery $delivery)
    {
        $this->authorize('update', $delivery);

        $delivery->reference = $request->reference;
        $delivery->contact_id = $request->contact_id;
        $delivery->order_id = $request->order_id;
        $delivery->to_deliver_at = $request->to_deliver_at;

        if ($request->has('note')) {
            $delivery->note = $request->note;
        }

        $delivery->save();

        return response($delivery, 200);
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return response(null, 204);
    }
}
