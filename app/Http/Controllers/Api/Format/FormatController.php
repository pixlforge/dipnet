<?php

namespace Dipnet\Http\Controllers\Api\Format;

use Dipnet\Format;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\FormatsCollection;

class FormatController extends Controller
{
    /**
     * FormatController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return FormatsCollection
     */
    public function index()
    {
        return new FormatsCollection(
            Format::orderBy('name')
                ->paginate(25)
        );
    }
}
