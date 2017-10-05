<?php

namespace App\Http\Controllers\Profiles;

use App\User;
use App\Company;
use App\Contact;
use App\Profile;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * ProfilesController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.account.contact',
            'user.account.company'
        ]);
    }

    /**
     * Profile
     */
    public function profile()
    {
        $this->authorize('view', Profile::class);

        $user = User::select([
            'id',
            'username',
            'email',
            'email_confirmed',
            'company_id',
            'created_at'
        ])->where('id', auth()->id())
            ->firstOrFail();

        $users = User::where('company_id', $user->company->id)
            ->get()
            ->sortBy('username');

        $contacts = Contact::where('company_id', $user->company->id)
            ->get()
            ->sortBy('name');

        return view('profiles.profile', compact([
            'user',
            'users',
            'contacts'
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
            'user',
            'contacts',
            'companies'
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

        if (empty($request->password)) {
            $this->updateUserWithoutPassword($user);
        } else {
            $this->updateUserWithPassword($user);
        }

        return redirect()->route('profile');
    }

    /**
     * @param Request $request
     * @param User $user
     */
    protected function updateUserWithoutPassword(Request $request, User $user)
    {
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'company_id' => $request->company_id
        ]);
    }

    /**
     * @param User $user
     */
    protected function updateUserWithPassword(Request $request, User $user)
    {
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'company_id' => $request->company_id
        ]);
    }
}