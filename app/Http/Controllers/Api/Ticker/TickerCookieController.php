<?php

namespace App\Http\Controllers\Api\Ticker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TickerCookieController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return response($request->id, 200)->cookie('ticker', $request->id, 10080);
    }
}
