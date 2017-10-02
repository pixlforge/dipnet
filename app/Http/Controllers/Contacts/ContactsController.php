<?php

namespace App\Http\Controllers\Contacts;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactsController extends Controller
{
    use SoftDeletes;

    /**
     * ContactsController constructor.
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
        $this->authorize('view', Contact::class);

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
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
    {
        $this->authorize('create', Contact::class);

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

        if (request()->expectsJson()) {
            return $contact->id;
        }

        return redirect()->route('contacts.index');
    }

    /**
     * Display the specified Contact.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Update the specified Contact.
     *
     * @param ContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

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

        if (request()->expectsJson()) {
            return response([], 204);
        }

        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('contacts.index');
    }
}
