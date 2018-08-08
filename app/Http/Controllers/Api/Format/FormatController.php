<?php

namespace App\Http\Controllers\Api\Format;

use App\Format;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormatsCollection;

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
     * Fetch formats.
     *
     * @param string $sort
     * @return FormatsCollection
     */
    public function index($sort = 'name')
    {
        if ($sort === 'height' || $sort === 'width' || $sort === 'created_at') {
            return new FormatsCollection(
                Format::orderBy($sort, 'desc')->paginate(25)
            );
        } else {
            return new FormatsCollection(
                Format::orderBy($sort)->paginate(25)
            );
        }
    }
}
