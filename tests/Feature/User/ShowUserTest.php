<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_a_users_show_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->create();

        $response = $this->get(route('admin.users.show', $user));

        $response->assertOk();
        $response->assertViewIs('admin.users.show');
    }

    /** @test */
    public function users_cannot_access_the_admin_user_show_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.users.show', $user));

        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_admin_user_show_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $user = factory(User::class)->states('user')->create();

        $response = $this->get(route('admin.users.show', $user));

        $response->assertRedirect(route('login'));
    }
}
