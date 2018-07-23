<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersCollection;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($sort = null)
    {
        if ($sort) {
            if ($sort === 'created_at' || $sort === 'role') {
                return new UsersCollection(User::orderBy($sort, 'desc')->paginate(25));
            } else {
                return new UsersCollection(User::orderBy($sort)->paginate(25));
            }
        } else {
            return new UsersCollection(User::orderBy('role', 'username')->paginate(25));
        }
    }
}
