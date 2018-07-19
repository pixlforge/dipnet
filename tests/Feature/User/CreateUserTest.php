<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmailConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_new_users()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertOk();
        $this->assertCount(2, User::all());
        Mail::assertQueued(RegistrationEmailConfirmation::class, function ($mail) {
            return $mail->hasTo('john@example.com');
        });
    }

    /** @test */
    public function users_cannot_create_new_users()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertForbidden();
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function guests_cannot_create_new_users()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertRedirect(route('login'));
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_username_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => '',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('username');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_username_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 123,
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('username');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_username_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => str_repeat('a', 2),
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('username');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_username_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => str_repeat('a', 256),
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('username');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_email_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => '',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('email');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_email_format_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('email');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_email_format_is_already_exists()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class)->states('user')->create(['email' => 'john@example.com']);

        $this->assertCount(2, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);
        
        $response->assertJsonValidationErrors('email');
        $this->assertCount(2, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_email_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => str_repeat('a', 244) . '@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'utilisateur',
        ]);

        $response->assertJsonValidationErrors('email');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_password_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '',
            'password_confirmation' => '',
            'role' => 'utilisateur',
        ]);

        $response->assertJsonValidationErrors('password');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_password_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 123456,
            'password_confirmation' => 123456,
            'role' => 'utilisateur',
        ]);

        $response->assertJsonValidationErrors('password');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_password_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => str_repeat('a', 5),
            'password_confirmation' => str_repeat('a', 5),
            'role' => 'utilisateur',
        ]);

        $response->assertJsonValidationErrors('password');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_passwords_do_not_match()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'something',
            'password_confirmation' => 'something-else',
            'role' => 'utilisateur',
        ]);

        $response->assertJsonValidationErrors('password');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_role_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => '',
        ]);

        $response->assertJsonValidationErrors('role');
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function store_user_validation_fails_if_role_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(1, User::all());

        $response = $this->postJson(route('admin.users.store'), [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'role' => 'nonexistent-role',
        ]);

        $response->assertJsonValidationErrors('role');
        $this->assertCount(1, User::all());
    }
}
