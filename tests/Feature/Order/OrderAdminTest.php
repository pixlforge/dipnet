<?php

namespace Tests\Feature\Order;

use Dipnet\Order;
use Dipnet\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_access_the_show_page()
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
    function guests_cannot_access_the_show_page()
    {
        $this->withExceptionHandling();

        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function users_who_are_not_admins_cannot_access_the_show_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertStatus(403);
    }
}
