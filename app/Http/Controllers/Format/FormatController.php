<?php

namespace App\Http\Controllers\Format;

use App\Format;
use App\Http\Controllers\Controller;
use App\Http\Requests\Format\StoreFormatRequest;
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
     * Display a listing of the Format models.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('formats.index');
    }

    /**
     * Store a new Format.
     *
     * @param StoreFormatRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreFormatRequest $request)
    {
        $format = Format::create([
            'name' => $request->name,
            'height' => $request->height,
            'width' => $request->width
        ]);

        return response($format, 200);
    }

    /**
     * Update a Format.
     *
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
     * Delete the Format.
     *
     * @param Format $format
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Format $format)
    {
        $this->authorize('delete', $format);

        $format->delete();

        return response(null, 204);
    }
}