<?php

namespace App\Http\Controllers\Delivery;

use App\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function update(Request $request, Delivery $delivery)
    {
        // authorize
        $delivery->note = $request->note;
        $delivery->save();

        return response(null, 200);
    }

    public function destroy(Delivery $delivery)
    {
        // authorize
        $delivery->note = null;
        $delivery->save();

        return response(null, 200);
    }
}
