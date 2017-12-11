<?php

namespace Tests\Feature\User;

use Dipnet\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_all_users()
    {
        $user = factory(User::class)->states('admin')->create([
            'username' => 'John Doe'
        ]);
        $this->signIn($user);

        $this->get(route('users.index'))
            ->assertStatus(200)
            ->assertSee('John Doe');
    }

    /** @test */
    function an_admin_can_update_a_user()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $user = factory(User::class)
            ->states('not-confirmed')
            ->create([
                'username' => 'John Doe',
                'email' => 'johndoe@example.com',
            ]);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $this->putJson(route('users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'role' => 'utilisateur'
        ])->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com'
        ]);
    }

    /** @test */
    function an_admin_can_delete_a_user()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $user = factory(User::class)
            ->states('not-confirmed')
            ->create([
                'username' => 'John Doe',
                'email' => 'johndoe@example.com',
            ]);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $this->deleteJson(route('users.destroy', $user))->assertStatus(204);
        $this->assertNotNull($user->fresh()->deleted_at);
    }
}