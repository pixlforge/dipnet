<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_delete_existing_users()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create();
        $this->assertNull($user->deleted_at);

        $response = $this->deleteJson(route('admin.users.destroy', $user));
        $response->assertSuccessful();
        $this->assertNotNull($user->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_delete_existing_users()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $otherUser = factory(User::class)->states('user')->create();
        $this->assertNull($otherUser->deleted_at);

        $response = $this->deleteJson(route('admin.users.destroy', $otherUser));
        $response->assertForbidden();
        $this->assertNull($otherUser->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_existing_users()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $user = factory(User::class)->states('user')->create();
        $this->assertNull($user->deleted_at);

        $response = $this->deleteJson(route('admin.users.destroy', $user));
        $response->assertRedirect(route('login'));
        $this->assertNull($user->fresh()->deleted_at);
    }
}
