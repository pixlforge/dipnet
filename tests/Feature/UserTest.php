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
     * User edit view is available and requires a user
     *
     * @test
     */
    function user_edit_view_is_available_and_requires_a_user()
    {
        $response = $this->get('/users/' . $this->user->username . '/edit');

        $response->assertViewIs('users.edit');
    }
}
