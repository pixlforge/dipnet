<?php

namespace Dipnet\Http\Controllers\Auth;

use Dipnet\Contact;
use Illuminate\Http\Request;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Register\RegisterContactRequest;

class RegisterContactOnlyController extends Controller
{
    /**
     * RegisterContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new contact and associate a newly created user with it.
     *
     * @param RegisterContactRequest $request
     */
    public function store(RegisterContactRequest $request)
    {
        Contact::create([
            'name' => $request->name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'zip' => $request->zip,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'fax' => $request->fax,
            'email' => auth()->user()->email,
            'user_id' => auth()->id()
        ]);

        auth()->user()->confirmContact();
        auth()->user()->confirmCompany();
    }
}
