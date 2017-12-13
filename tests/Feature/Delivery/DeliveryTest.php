<?php

namespace Tests\Feature\Delivery;

use Dipnet\Delivery;
use Dipnet\Order;
use Dipnet\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Global setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->admin = factory(User::class)->states('admin')->create();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    function an_admin_can_access_the_deliveries_index_page()
    {
        $this->actingAs($this->admin);

        $this->get(route('deliveries.index'))
            ->assertStatus(200)
            ->assertViewIs('deliveries.index');
    }

    /** @test */
    function guests_cannot_access_the_deliveries_index_page()
    {
        $this->get(route('deliveries.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function users_who_are_not_admins_cannot_access_the_deliveries_index_page()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $this->get(route('deliveries.index'))
            ->assertStatus(403);
    }

    /** @test */
    function admins_can_create_new_deliveries()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin);

        $order = factory(Order::class)->create();

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id,
        ])->assertStatus(200);

        $deliveries = Delivery::all();
        $this->assertCount(1, $deliveries);
    }

    /** @test */
    function guests_cannot_create_deliveries()
    {
        $order = factory(Order::class)->create();

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id,
        ])->assertRedirect(route('login'));

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);
    }

    /** @test */
    function users_who_are_not_admins_cannot_create_new_deliveries()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $order = factory(Order::class)->create();

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id,
        ])->assertStatus(403);

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);
    }

    /** @test */
    function admins_can_update_deliveries()
    {
        $this->actingAs($this->admin);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'order_id' => $order->id
        ]);

        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);

        $this->putJson(route('deliveries.update', $delivery), [
            'reference' => 'abcdef',
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ])->assertStatus(200);

        $this->assertDatabaseMissing('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);
        $this->assertDatabaseHas('deliveries', [
            'reference' => 'abcdef',
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ]);
    }

    /** @test */
    function guests_cannot_update_deliveries()
    {
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'order_id' => $order->id
        ]);

        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);

        $this->putJson(route('deliveries.update', $delivery), [
            'reference' => 'abcdef',
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ])->assertStatus(302);

        $this->assertDatabaseMissing('deliveries', [
            'reference' => 'abcdef',
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ]);
        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);
    }
    
    /** @test */
    function users_who_are_not_admins_cannot_update_deliveries()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'order_id' => $order->id
        ]);

        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);

        $this->putJson(route('deliveries.update', $delivery), [
            'reference' => 'abcdef',
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ])->assertStatus(403);

        $this->assertDatabaseMissing('deliveries', [
            'reference' => 'abcdef',
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ]);
        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);
    }

    /** @test */
    function admins_can_delete_deliveries()
    {
        $this->actingAs($this->admin);

        $delivery = factory(Delivery::class)->create();

        $this->assertNull($delivery->deleted_at);

        $this->deleteJson(route('deliveries.destroy', $delivery))
            ->assertStatus(204);

        $this->assertNotNull($delivery->fresh()->deleted_at);
    }

    /** @test */
    function guests_cannot_delete_deliveries()
    {
        $delivery = factory(Delivery::class)->create();

        $this->assertNull($delivery->deleted_at);

        $this->deleteJson(route('deliveries.destroy', $delivery))
            ->assertStatus(302);

        $this->assertNull($delivery->fresh()->deleted_at);
    }

    /** @test */
    function users_who_are_not_admins_cannot_delete_deliveries()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $delivery = factory(Delivery::class)->create();

        $this->assertNull($delivery->deleted_at);

        $this->deleteJson(route('deliveries.destroy', $delivery))
            ->assertStatus(403);

        $this->assertNull($delivery->fresh()->deleted_at);
    }
}
