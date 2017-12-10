<?php

namespace Dipnet\Http\Controllers\Format;

use Dipnet\Format;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Format\StoreFormatRequest;
use Dipnet\Http\Requests\Format\UpdateFormatRequest;

class FormatController extends Controller
{
    /**
     * FormatController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Format models.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Format::class);

        $formats = Format::latest()
            ->orderBy('name')
            ->get()
            ->toJson();

        if (request()->wantsJson()) {
            return $formats;
        }

        return view('formats.index', compact('formats'));
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
            'width' => $request->width,
            'surface' => $request->surface,
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
        $format->update([
            'name' => $request->name,
            'height' => $request->height,
            'width' => $request->width,
            'surface' => $request->surface
        ]);

        return response($format, 200);
    }

    /**
     * Delete the Format.
     *
     * @param Format $format
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Format $format)
    {
        $this->authorize('delete', $format);

        $format->delete();

        return response(null, 204);
    }
}