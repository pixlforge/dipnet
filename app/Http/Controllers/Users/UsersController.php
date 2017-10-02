<?php

namespace App\Http\Controllers\Users;

use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

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

        $users = User::with('company')
            ->orderBy('username')
            ->get();

        return view('users.index', compact('users'));
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

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email' => $request->email,
            'confirmed' => $this->getEmailStatus(),
            'company_id' => $request->company_id
        ]);

        if (request()->expectsJson()) {
            return $user->id;
        }

        return redirect()->route('users.index');
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
            'username' => $request->username,
            'role' => $request->role,
            'email' => $request->email,
            'email_confirmed' => $this->getEmailStatus(),
            'company_id' => $request->company_id
        ]);

        return redirect()->route('users.index');
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

        return redirect()->route('users.index');
    }

    /**
     * @return int
     */
    protected function getEmailStatus(): int
    {
        if (empty($request->email_confirmed)) {
            $emailStatus = 0;
        } else {
            $emailStatus = 1;
        }
        return $emailStatus;
    }
}