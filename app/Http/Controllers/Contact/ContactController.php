<?php

namespace Dipnet\Http\Controllers\Contact;

use Dipnet\Contact;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Contact\UpdateContactRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dipnet\Http\Requests\Contact\StoreContactRequest;

class ContactController extends Controller
{
    use SoftDeletes;

    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.account.contact',
            'user.account.company'
        ]);
        $this->middleware('user.email.confirmed')->except('index');
    }

    /**
     * Display a listing of the Contat model.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $contacts = Contact::latest()
                ->with('company')
                ->orderBy('name')
                ->get()
                ->toJson();
        } else {
            $contacts = Contact::where('company_id', auth()->user()->company_id)
                ->with('company')
                ->latest()
                ->orderBy('name')
                ->get()
                ->toJson();
        }

        if (request()->wantsJson()) {
            return $contacts;
        }

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Save a new Contact model.
     *
     * @param StoreContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create([
            'name' => $request->name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'zip' => $request->zip,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'fax' => $request->fax,
            'email' => $request->email,
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id
        ]);

        $contact = $contact->with('company')->find($contact->id);

        return response($contact, 200);
    }

    /**
     * Display the specified Contact.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Update the Contact.
     *
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update([
            'name' => $request->name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'zip' => $request->zip,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'fax' => $request->fax,
            'email' => $request->email,
            'company_id' => $request->company_id
        ]);

        return response($contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response(null, 204);
    }
}
