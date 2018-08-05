<?php

namespace Tests\Feature\Delivery;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListDeliveriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_deliveries_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.deliveries.index'));
        $response->assertOk();
        $response->assertViewIs('admin.deliveries.index');
        $response->assertSee('Liste de toutes les livraisons');
    }

    /** @test */
    public function users_cannot_access_the_deliveries_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.deliveries.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_deliveries_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.deliveries.index'));
        $response->assertRedirect(route('login'));
    }
}
