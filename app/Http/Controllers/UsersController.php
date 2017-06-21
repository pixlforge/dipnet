<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', User::class);

        $users = User::withTrashed()
            ->with(['contact', 'company'])
            ->get()
            ->sortBy('username');

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        User::create([
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'role' => request('role'),
            'email' => request('email'),
            'email_validated' => 0,
            'contact_id' => request('contact_id'),
            'company_id' => request('company_id')
        ]);

        return redirect()->route('users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $contacts = Contact::all();

        $companies = Company::all();

        return view('users.edit', compact([
            'user', 'contacts', 'companies'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update([
            'username' => request('username'),
            'role' => request('role'),
            'email' => request('email'),
            'contact_id' => request('contact_id'),
            'company_id' => request('company_id')
        ]);

        return redirect()->route('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($user)
    {
        $this->authorize('restore', User::class);

        User::onlyTrashed()->where('id', $user)->restore();

        return redirect()->route('users');
    }
}
