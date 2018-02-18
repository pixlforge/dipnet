<?php

namespace Dipnet\Http\Controllers\Delivery;

use Dipnet\Delivery;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Delivery\StoreDeliveryRequest;
use Dipnet\Http\Requests\Delivery\UpdateDeliveryRequest;
use Dipnet\Http\Requests\DeliveryRequest;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Delivery::class);

        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Store a new Delivery.
     *
     * @param StoreDeliveryRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreDeliveryRequest $request)
    {
        $delivery = new Delivery;
        $delivery->reference = date('Ymd') . '-' . substr(str_slug(auth()->user()->company->name), 0, 8) . '-del-' . str_random(5);
        $delivery->order_id = $request->order_id;
        $delivery->save();

        return response($delivery, 200);
    }

    /**
     * Update a delivery.
     *
     * @param UpdateDeliveryRequest $request
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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

    /**
     * Delete the Delivery.
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Delivery $delivery)
    {
        $this->authorize('delete', $delivery);

        $delivery->delete();

        return response(null, 204);
    }
}