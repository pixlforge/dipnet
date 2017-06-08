<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A user can be inserted into the database
     *
     * @test
     */
    function a_user_can_be_inserted_into_the_database()
    {
        $user = factory('App\User')->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
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

        $user = \App\User::findOrFail($user->id);
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
