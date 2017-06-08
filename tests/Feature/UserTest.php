<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Create a User for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();
        return $this->user = factory('App\User')->create();
    }

    /**
     * User index view is available
     *
     * @test
     */
    function user_index_view_is_available()
    {
        $response = $this->get('/users');
        $response->assertViewIs('users.index');
    }

    /**
     * User create view is available
     *
     * @test
     */
    function user_create_view_is_available()
    {
        $response = $this->get('/users/create');
        $response->assertViewIs('users.create');
    }

    /**
     * User show view is available and requires a user
     *
     * @test
     */
    function user_show_view_is_available_and_requires_a_user()
    {
        $response = $this->get('/users/' . $this->user->username);
        $response->assertViewIs('users.show');
    }

    /**
     * User edit view is available and requires a user
     *
     * @test
     */
    function user_edit_view_is_available_and_requires_a_user()
    {
        $response = $this->get('/users/' . $this->user->username . '/edit');
        $response->assertViewIs('users.edit');
    }

    /**
     * A user can be inserted into the database
     *
     * @test
     */
    function a_user_can_be_inserted_into_the_database()
    {
        $user = factory('App\User')->create();
//        $user = User::create([
//            'username' => 'Toto',
//            'password' => bcrypt('erfgbn'),
//            'role' => 'user',
//            'email' => 'username@email.ch',
//        ]);
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    /**
     * Multiple users can be created
     *
     * @test
     */
    function multiple_users_can_be_created()
    {
        factory('App\User', 10)->create();
    }

    /**
     * A user can be created and then read from the database
     *
     * @test
     */
    function a_user_can_be_created_and_then_read_from_the_database()
    {
        $user = factory('App\User')->create();
        $this->assertDatabaseHas('users', [
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }

    /**
     * A user's username can be modified
     *
     * @test
     */
    function a_users_username_can_be_modified()
    {
        $user = factory('App\User')->create();
        $this->assertDatabaseHas('users', [
            'username' => $user->username,
        ]);

        $newUsername = 'Conor McGregor';

        $user = User::findOrFail($user->id);
        $user->username = $newUsername;
        $user->save();

        $this->assertDatabaseHas('users', [
            'username' => $newUsername
        ]);
    }

    /**
     * A user can be deleted
     *
     * @test
     */
//    function a_user_can_be_deleted()
//    {
//        $user = factory('App\User')->create();
//        $this->assertDatabaseHas('users', [
//            'username' => $user->username,
//        ]);
//
//        $userToDelete = \App\User::find(1);
//        $userToDelete->delete();
//        $this->assertDatabaseHas('users', [
//            'username' => $user->username,
//        ]);
//    }
    
    /**
     * A soft deleted user can be restored
     * 
     * @test
     */
    function a_soft_deleted_user_can_be_restored()
    {
        $user = factory('App\User')->create();
        $user->delete();
        $user->restore();
        $this->assertDatabaseHas('users', [
            'deleted_at' => null,
        ]);
    }

}
