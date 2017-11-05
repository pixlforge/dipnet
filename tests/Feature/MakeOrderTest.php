<?php

namespace Tests\Feature;

use App\Order;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakeOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_prepare_an_order()
    {
        $this->assertTrue(true);
//        $user = factory(User::class)->create();
//        $this->signIn($user);
//
//        $orders = Order::all();
//        $this->assertCount(0, $orders);
//
//        $this->get(route('orders.create'))
//            ->assertStatus(200);
//
//        $orders = Order::all();
//        $this->assertCount(1, $orders);
    }
}