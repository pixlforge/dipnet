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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.deliveries.index');
    }

    /**
     * @param UpdateAdminDeliveryRequest $request
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateAdminDeliveryRequest $request, Delivery $delivery)
    {
        $delivery->note = $request->note;
        $delivery->admin_note = $request->admin_note;
        $delivery->contact_id = $request->contact_id;
        $delivery->to_deliver_at = $request->to_deliver_at;
        $delivery->save();

        return response($delivery, 200);
    }
}
