<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_orders_admin_show_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $order = factory(Order::class)->create();

        $response = $this->get(route('admin.orders.show', $order));
        $response->assertOk();
        $response->assertViewIs('admin.orders.show');
    }

    /** @test */
    public function users_cannot_access_the_orders_admin_show_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create();

        $response = $this->get(route('admin.orders.show', $order));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_orders_admin_show_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $order = factory(Order::class)->create();

        $response = $this->get(route('admin.orders.show', $order));
        $response->assertRedirect(route('login'));
    }
}
