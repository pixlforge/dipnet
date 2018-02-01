<?php

namespace Dipnet\Http\Controllers\Api\User;

use Dipnet\User;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\UsersCollection;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return UsersCollection
     */
    public function index()
    {
        return new UsersCollection(User::orderBy('role', 'username')->paginate(25));
    }
}
