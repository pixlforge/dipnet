<?php

namespace Tests\Feature\Delivery;

use Dipnet\Delivery;
use Dipnet\Order;
use Dipnet\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Global setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->admin = factory(User::class)->states('admin')->create();
    }

    /** @test */
    function store_delivery_validation_fails_if_no_order_is_provided()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin);

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [])
            ->assertStatus(422);

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);
    }

    /** @test */
    function update_delivery_validation_fails_if_no_reference_is_provided()
    {
        $this->withExceptionHandling();

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
            'note' => "Lorem ipsum dolor sit amet.",
            'order_id' => $order->id
        ])->assertStatus(422);

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
    function update_delivery_validation_fails_if_reference_already_exists()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin);

        $firstOrder = factory(Order::class)->create();
        factory(Delivery::class)->create([
            'reference' => 'abcdef',
            'order_id' => $firstOrder->id
        ]);

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
        ])->assertStatus(422);

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
}
