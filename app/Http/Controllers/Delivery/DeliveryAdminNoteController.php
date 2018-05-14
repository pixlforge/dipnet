<?php

namespace App\Http\Controllers\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryAdminNoteController extends Controller
{
    /**
     * DeliveryAdminNoteController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @param Delivery $delivery
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Delivery $delivery, Request $request)
    {
        $delivery->admin_note = $request->admin_note;
        $delivery->save();

        return response($delivery, 200);
    }
}
