<?php

namespace App\Http\Controllers\Admin\Format;

use App\Http\Controllers\Controller;
use App\Http\Requests\Format\StoreFormatRequest;
use App\Format;
use App\Http\Requests\Format\UpdateFormatRequest;

class FormatController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.formats.index');
    }

    public function store(StoreFormatRequest $request)
    {
        $format = new Format;
        $format->name = $request->name;
        $format->height = $request->height;
        $format->width = $request->width;
        $format->save();

        return response($format, 200);
    }

    public function update(UpdateFormatRequest $request, Format $format)
    {
        $format->name = $request->name;
        $format->height = $request->height;
        $format->width = $request->width;
        $format->save();

        return response($format, 200);
    }

    public function destroy(Format $format)
    {
        $format->delete();

        return response(null, 204);
    }
}
