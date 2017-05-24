<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

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
        factory('App\User')->create();
    }
}
