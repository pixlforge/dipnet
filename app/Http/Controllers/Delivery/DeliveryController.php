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
    /**
     * DeliveryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new delivery and associate it with its order.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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

    /**
     * Update an existing delivery.
     *
     * @param UpdateUserDeliveryRequest $request
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserDeliveryRequest $request, Delivery $delivery)
    {
        $this->authorize('touch', $delivery);

        $delivery->note = $request->note;

        if (auth()->user()->isNotSolo()) {
            $delivery->contact_id = $request->contact_id;
        }
        
        $delivery->to_deliver_at = $request->to_deliver_at;
        $delivery->pickup = $request->pickup;
        $delivery->express = $request->express;
        $delivery->save();

        return response($delivery, 200);
    }

    /**
     * Delete an existing delivery.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException|\Exception
     */
    public function destroy(Delivery $delivery)
    {
        $this->authorize('touch', $delivery);

        $delivery->delete();

        return response(null, 204);
    }
}
