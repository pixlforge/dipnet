<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
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
            ->get()
            ->toJson();

        $companies = Company::orderBy('name')
            ->get()
            ->toJson();

        return view('users.index', [
            'users' => $users,
            'companies' => $companies
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email' => $request->email,
            'confirmed' => $this->getEmailStatus(),
            'company_id' => $request->company_id
        ]);

        return response($user, 200);
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

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'username' => $request->username,
            'role' => $request->role,
            'email' => $request->email,
            'email_confirmed' => $this->getEmailStatus(),
            'company_id' => $request->company_id
        ]);

        return response($user, 200);
    }

    /**
     * Delete the User.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response(null, 204);
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