<?php

namespace Tests\Feature\Business;

use App\User;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_soft_delete_existing_businesses()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $business = factory(Business::class)->create();
        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('admin.businesses.destroy', $business));
        $response->assertSuccessful();
        $this->assertNotNull($business->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_soft_delete_existing_businesses()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create();
        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('admin.businesses.destroy', $business));
        $response->assertForbidden();
        $this->assertNull($business->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_soft_delete_existing_businesses()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $business = factory(Business::class)->create();
        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('admin.businesses.destroy', $business));
        $response->assertRedirect(route('login'));
        $this->assertNull($business->fresh()->deleted_at);
    }
}
