<?php

namespace App\Http\Controllers\Admin\Ticker;

use App\Ticker;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticker\StoreTickerRequest;
use App\Http\Requests\Ticker\UpdateTickerRequest;

class TickerController extends Controller
{
    /**
     * TickerController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a list of all tickers.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tickers = Ticker::all();

        return view('admin.tickers.index', compact('tickers'));
    }

    /**
     * Store a new ticker.
     *
     * @param StoreTickerRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreTickerRequest $request)
    {
        $this->setTickersInactive($request);

        $ticker = new Ticker;
        $ticker->body = $request->body;
        $ticker->active = $request->active;
        $ticker->save();

        return response($ticker, 200);
    }

    /**
     * Update an existing ticker.
     *
     * @param UpdateTickerRequest $request
     * @param Ticker $ticker
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateTickerRequest $request, Ticker $ticker)
    {
        $this->setTickersInactive($request);

        $ticker->body = $request->body;
        $ticker->active = $request->active;
        $ticker->save();

        return response($ticker, 200);
    }

    /**
     * Delete an existing ticker.
     *
     * @param Ticker $ticker
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Ticker $ticker)
    {
        $ticker->delete();

        return response(null, 201);
    }

    /**
     * Set all existing tickets as inactive.
     *
     * @param $request
     */
    protected function setTickersInactive($request)
    {
        if ($request->active) {
            $tickers = Ticker::all();
            foreach ($tickers as $ticker) {
                $ticker->active = false;
                $ticker->save();
            }
        }
    }
}
