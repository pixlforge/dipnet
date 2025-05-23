<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\UpdateAdminDeliveryRequest;

class DeliveryController extends Controller
{
    /**
     * DeliveryController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Update an existing delivery.
     *
     * @param UpdateAdminDeliveryRequest $request
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateAdminDeliveryRequest $request, Delivery $delivery)
    {
        $delivery->note = $request->note;
        $delivery->admin_note = $request->admin_note;
        $delivery->contact_id = $request->contact_id;
        $delivery->pickup = $request->pickup;
        $delivery->to_deliver_at = $request->to_deliver_at;
        $delivery->express = $request->express;
        $delivery->save();

        return response($delivery, 200);
    }
}
