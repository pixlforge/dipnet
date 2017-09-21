<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    function user_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/users');

        $response->assertViewIs('users.index');
    }

    /** @test */
    function authorized_users_can_create_users()
    {
        $this->signIn(null, 'administrateur');

        $user = factory('App\User')->create();

        $this->get('/users')
            ->assertStatus(200);
    }

    /** @test */
    function authorized_users_can_update_users()
    {
        $this->signIn(null, 'administrateur');

        $user = factory('App\User')->create();

        $user->username = 'John Doe';

        $this->put("/users/{$user->id}", $user->toArray())
            ->assertRedirect('users');
    }

    /** @test */
    function authorized_users_can_delete_users()
    {
        $this->signIn(null, 'administrateur');

        $user = factory('App\User')->create();
        $this->assertDatabaseHas('users', [
            'username' => $user->username,
            'email' => $user->email,
        ]);

        $this->delete("/users/{$user->id}")
            ->assertRedirect('/users');
    }

    /** @test */
    function authorized_users_can_restore_users()
    {
        $this->signIn(null, 'administrateur');

        $user = factory('App\User')->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);

        $this->delete("/users/{$user->id}")
            ->assertRedirect('/users');

        $this->put("/users/{$user->id}/restore", $user->toArray())
            ->assertRedirect('/users');
    }
}
