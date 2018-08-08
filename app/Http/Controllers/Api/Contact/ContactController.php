<?php

namespace App\Http\Controllers\Api\Contact;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactsCollection;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch contacts.
     *
     * @param string $sort
     * @return ContactsCollection
     */
    public function index($sort = 'name')
    {
        if (auth()->user()->isAdmin()) {
            if ($sort === 'created_at') {
                return new ContactsCollection(
                    Contact::with('company')->orderBy($sort, 'desc')->paginate(25)
                );
            } else {
                return new ContactsCollection(
                    Contact::with('company')->orderBy($sort)->paginate(25)
                );
            }
        } elseif (auth()->user()->isNotSolo()) {
            if ($sort === 'created_at') {
                return new ContactsCollection(
                    Contact::where('company_id', auth()->user()->company->id)->orderBy($sort, 'desc')->paginate(25)
                );
            } else {
                return new ContactsCollection(
                    Contact::where('company_id', auth()->user()->company->id)->orderBy($sort)->paginate(25)
                );
            }
        } elseif (auth()->user()->isSolo()) {
            if ($sort === 'created_at') {
                return new ContactsCollection(
                    Contact::where('user_id', auth()->id())->orderBy($sort, 'desc')->paginate(25)
                );
            } else {
                return new ContactsCollection(
                    Contact::where('user_id', auth()->id())->orderBy($sort)->paginate(25)
                );
            }
        }
    }
}
