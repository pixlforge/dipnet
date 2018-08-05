<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Business;

class OrderAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_show_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertStatus(200)
            ->assertViewIs('orders.show');
    }

    /** @test */
    public function guests_cannot_access_the_show_page()
    {
        $this->withExceptionHandling();

        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function users_who_are_not_admins_cannot_access_the_show_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertStatus(403);
    }

    /** @test */
    public function admins_can_access_the_delivery_receipt()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $business = factory(Business::class)->create();
        $order = factory(Order::class)->states('add-contact')->create(['business_id' => $business->id]);
        $delivery = factory(Delivery::class)->states('add-contact')->create(['order_id' => $order->id]);

        $response = $this->get(route('deliveries.receipts.show', $delivery));
        $response->assertOk();
        $response->assertViewIs('deliveries.receipts.show');
    }
}
