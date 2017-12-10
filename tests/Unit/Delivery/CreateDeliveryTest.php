<?php

namespace Tests\Unit\Delivery;

use Dipnet\Delivery;
use Dipnet\Order;
use Dipnet\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeliveryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_delivery_can_be_created()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $order = factory(Order::class)->create();
        $order = Order::whereReference($order->reference)->first();

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id
        ])->assertStatus(200);

        $deliveries = Delivery::all();
        $this->assertCount(1, $deliveries);
    }
}
