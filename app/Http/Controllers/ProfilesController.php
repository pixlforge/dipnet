<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Http\Requests\CompanyDetailRequest;
use App\Http\Requests\ContactDetailsRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\User;
use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * ProfilesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Profile
     */
    public function profile()
    {
        $this->authorize('view', Profile::class);

        $user = User::where('id', auth()->id())
            ->firstOrFail([
                'id', 'username', 'email', 'email_validated', 'contact_id',
                'company_id', 'last_login_at', 'created_at'
            ]);

        $users = User::where('company_id', $user->company->id)
            ->get()
            ->sortBy('username');

        $contacts = Contact::where('company_id', $user->company->id)
            ->get()
            ->sortBy('name');

        return view('profiles.profile', compact([
            'user', 'users', 'contacts'
        ]));
    }

    public function edit(User $user)
    {
        if (auth()->user()->id != $user->id) {
            abort(403, "Vous n'êtes pas autorisé à faire cela");
        }

        $contacts = Contact::all()
            ->sortBy('name');

        $companies = Company::all()
            ->sortBy('name');

        return view('profiles.edit', compact([
            'user', 'contacts', 'companies'
        ]));
    }

    /**
     * @param UpdateProfileRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request, User $user)
    {
        if (auth()->user()->id != $user->id) {
            abort(403, "Vous n'êtes pas autorisé à faire cela");
        }

        if(empty(request('password'))) {
            $this->updateUserWithoutPassword($user);
        } else {
            $this->updateUserWithPassword($user);
        }

        return redirect()->route('profile');
    }

    /**
     * @param User $user
     */
    protected function updateUserWithoutPassword(User $user)
    {
        $user->update([
            'username' => request('username'),
            'email' => request('email'),
            'contact_id' => request('contact_id'),
            'company_id' => request('company_id')
        ]);
    }

    /**
     * @param User $user
     */
    protected function updateUserWithPassword(User $user)
    {
        $user->update([
            'username' => request('username'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'contact_id' => request('contact_id'),
            'company_id' => request('company_id')
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactDetails(User $user)
    {
        return view('profiles.contact-details');
    }


    /**
     * @param ContactDetailsRequest $request
     */
    public function contactDetailsStore(ContactDetailsRequest $request)
    {
        $contact = Contact::create([
            'name' => auth()->user()->username . request('name'),
            'address_line1' => request('address_line1'),
            'address_line2' => request('address_line2'),
            'zip' => request('zip'),
            'city' => request('city'),
            'phone_number' => request('phone_number'),
            'fax' => request('fax'),
            'email' => auth()->user()->email,
            'created_by_username' => auth()->user()->username
        ]);

        $this->associateUserWithContact($contact);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyDetails(User $user)
    {
        return view('profiles.company-details');
    }

    /**
     * @param CompanyDetailRequest $request
     */
    public function companyDetailsStore(CompanyDetailRequest $request)
    {
        if ($request->has('name')) {
            $name = request('name');
        } else {
            $name = auth()->user()->username;
        }

        $company = Company::create([
            'name' => $name,
            'created_by_username' => auth()->user()->username
        ]);

        $this->associateUserWithCompany($company);
    }

    public function associateUserWithContact($contact)
    {
        $user = User::where('id', auth()->user()->id)->firstOrFail();

        $user->update([
            'contact_id' => $contact->id
        ]);
    }

    /**
     * @param $company
     */
    public function associateUserWithCompany($company)
    {
        $user = User::where('id', auth()->user()->id)->firstOrFail();

        $user->update([
            'company_id' => $company->id
        ]);

        $this->associateContactWithCompany($company);
    }

    /**
     * @param $company
     */
    public function associateContactWithCompany($company)
    {
        $contact = Contact::where('id', auth()->user()->id)->firstOrFail();

        $contact->update([
            'company_id' => $company->id
        ]);
    }
}
