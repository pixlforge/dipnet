<?php

namespace App\Http\Controllers\Delivery;

use App\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryAdminNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function update(Delivery $delivery, Request $request)
    {
        $delivery->admin_note = $request->admin_note;
        $delivery->save();

        return response($delivery, 200);
    }
}
