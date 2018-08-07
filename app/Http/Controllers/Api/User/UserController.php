<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersCollection;

class UserController extends Controller
{
    private $fields = [
        'id',
        'username',
        'role',
        'email',
        'is_solo',
        'company_id',
        'created_at',
        'updated_at',
        'email_confirmed',
        'company_confirmed',
        'contact_confirmed',
    ];

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @param null $sort
     * @return UsersCollection
     */
    public function index($sort = null)
    {
        if ($sort) {
            if ($sort === 'created_at' || $sort === 'role') {
                $users = User::orderBy($sort, 'desc')->paginate(25, $this->fields);
            } else {
                $users = User::orderBy($sort)->paginate(25, $this->fields);
            }
        } else {
            $users = User::orderBy('role', 'username')->paginate(25, $this->fields);
        }

        return new UsersCollection($users);
    }
}
