<?php

namespace Dipnet\Http\Controllers\User;

use Dipnet\User;
use Dipnet\Company;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\User\StoreUserRequest;
use Dipnet\Http\Requests\User\UpdateUserRequest;

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->username = $request->username;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->email_confirmed = $this->getEmailStatus($user->email_confirmed);
        $user->company_id = $request->company_id;
        $user->save();

        return response($user, 200);
    }

    /**
     * Delete the User.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response(null, 204);
    }

    /**
     * @param $status
     * @return int
     */
    protected function getEmailStatus($status): int
    {
        if ($status == 1 && empty($request->email_confirmed)) {
            $emailStatus = 1;
        } else {
            $emailStatus = 0;
        }
        return $emailStatus;
    }
}