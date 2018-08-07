<?php

namespace App\Http\Controllers\Admin\Format;

use App\Http\Controllers\Controller;
use App\Http\Requests\Format\StoreFormatRequest;
use App\Format;
use App\Http\Requests\Format\UpdateFormatRequest;

class FormatController extends Controller
{
    /**
     * FormatController constructor.
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
        return view('admin.formats.index');
    }

    /**
     * @param StoreFormatRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreFormatRequest $request)
    {
        $format = new Format;
        $format->name = $request->name;
        $format->height = $request->height;
        $format->width = $request->width;
        $format->save();

        return response($format, 200);
    }

    /**
     * @param UpdateFormatRequest $request
     * @param Format $format
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateFormatRequest $request, Format $format)
    {
        $format->name = $request->name;
        $format->height = $request->height;
        $format->width = $request->width;
        $format->save();

        return response($format, 200);
    }

    /**
     * @param Format $format
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Format $format)
    {
        $format->delete();

        return response(null, 204);
    }
}
