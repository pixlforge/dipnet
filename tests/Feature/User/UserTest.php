<?php

namespace Tests\Feature\User;

use Dipnet\User;
use Illuminate\Support\Facades\Mail;
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
    function an_admin_can_create_a_new_user()
    {
        Mail::fake();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->assertCount(1, User::all());

        $this->postJson(route('users.store'), [
            'username' => 'John Doe',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
            'email' => 'johndoe@example.com',
            'email_confirmed' => 1,
            'company_id' => null
        ])->assertStatus(200);

        $this->assertCount(2, User::all());
    }

    /** @test */
    function guests_cannot_create_users()
    {
        $this->withExceptionHandling();

        $this->assertCount(0, User::all());

        $this->postJson(route('users.store'), [
            'username' => 'John Doe',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
            'email' => 'johndoe@example.com',
            'email_confirmed' => 1,
            'company_id' => null
        ])->assertStatus(401);

        $this->assertCount(0, User::all());
    }

    /** @test */
    function users_who_are_not_admins_cannot_create_users()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $this->assertCount(1, User::all());

        $this->postJson(route('users.store'), [
            'username' => 'John Doe',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
            'email' => 'johndoe@example.com',
            'email_confirmed' => 1,
            'company_id' => null
        ])->assertStatus(403);

        $this->assertCount(1, User::all());
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
    function an_admin_can_update_a_users_password()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);

        $user = User::where('email', 'johndoe@example.com')->first();

        $this->putJson(route('users.update', $user), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'hunter2',
            'password_confirmation' => 'hunter2',
            'role' => 'utilisateur'
        ])->assertStatus(200);
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