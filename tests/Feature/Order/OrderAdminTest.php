<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use App\Delivery;
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

    /** @test */
    function admins_can_add_a_note_only_admins_can_see()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $delivery = factory(Delivery::class)->create([
            'order_id' => function () {
                return factory(Order::class)->create();
            }
        ]);

        $this->assertNull($delivery->admin_note);

        $this->patchJson(route('deliveries.admin.note.update', $delivery), [
            'admin_note' => 'Lorem ipsum dolor sit amet.'
        ])->assertStatus(200);

        $this->assertNotNull($delivery->fresh()->admin_note);
    }

    /** @test */
    function guests_cannot_add_an_admin_note()
    {
        $delivery = factory(Delivery::class)->create([
            'order_id' => function () {
                return factory(Order::class)->create();
            }
        ]);

        $this->assertNull($delivery->admin_note);

        $this->patchJson(route('deliveries.admin.note.update', $delivery), [
            'admin_note' => 'Lorem ipsum dolor sit amet.'
        ])->assertRedirect(route('login'));

        $this->assertNull($delivery->fresh()->admin_note);
    }

    /** @test */
    function users_who_are_not_admins_cannot_add_admin_notes()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $delivery = factory(Delivery::class)->create([
            'order_id' => function () {
                return factory(Order::class)->create();
            }
        ]);

        $this->assertNull($delivery->admin_note);

        $this->patchJson(route('deliveries.admin.note.update', $delivery), [
            'admin_note' => 'Lorem ipsum dolor sit amet.'
        ])->assertStatus(403);

        $this->assertNull($delivery->fresh()->admin_note);
    }

    /** @test */
    function admins_can_access_the_delivery_receipt()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $delivery = factory(Delivery::class)->create([
            'order_id' => function () {
                return factory(Order::class)->create();
            }
        ]);

        $this->get(route('deliveries.receipts.show', $delivery))
            ->assertStatus(200)
            ->assertViewIs('deliveries.receipts.show');
    }
}
