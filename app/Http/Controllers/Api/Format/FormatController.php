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
