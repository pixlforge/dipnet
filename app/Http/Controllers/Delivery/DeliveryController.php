<?php

namespace App\Http\Controllers\Delivery;

use App\Order;
use App\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Hashids\HashidsGenerator;
use App\Http\Requests\Delivery\UpdateUserDeliveryRequest;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Order $order)
    {
        $this->authorize('touch', $order);

        $delivery = new Delivery;
        $delivery->order()->associate($order);
        $delivery->save();

        $delivery->reference = HashidsGenerator::generateFor($delivery->id, 'deliveries');
        $delivery->save();

        return response($delivery, 200);
    }

    public function update(UpdateUserDeliveryRequest $request, Delivery $delivery)
    {
        $this->authorize('touch', $delivery);

        $delivery->note = $request->note;
        $delivery->contact_id = $request->contact_id;
        $delivery->to_deliver_at = $request->to_deliver_at;
        $delivery->save();

        return response($delivery, 200);
    }

    public function destroy(Delivery $delivery)
    {
        $this->authorize('touch', $delivery);

        $delivery->delete();

        return response(null, 204);
    }
}
