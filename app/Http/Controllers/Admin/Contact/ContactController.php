<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Company;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreAdminContactRequest;
use App\Http\Requests\Contact\UpdateAdminContactRequest;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a list of all contacts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::all();

        return view('admin.contacts.index', compact('companies'));
    }

    /**
     * Store a new contact.
     *
     * @param StoreAdminContactRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreAdminContactRequest $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
        $contact->email = $request->email;
        $contact->company_id = $request->company_id;

        $contact->save();

        $contact->load('company');

        return response($contact, 200);
    }

    /**
     * Update an existing contact.
     *
     * @param UpdateAdminContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateAdminContactRequest $request, Contact $contact)
    {
        $contact->name = $request->name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
        $contact->email = $request->email;
        $contact->company_id = $request->company_id;

        $contact->save();

        return response($contact, 200);
    }

    /**
     * Delete an existing contact.
     *
     * @param Contact $contact
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response(null, 204);
    }
}
