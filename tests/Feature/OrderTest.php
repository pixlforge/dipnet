<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Order views are available
     *
     * @test
     */
    function order_views_are_available()
    {
        $response = $this->get('/orders');
        $response->assertViewIs('orders.index');

        $response = $this->get('/orders/create');
        $response->assertViewIs('orders.create');

        $response = $this->get('/orders/order-id');
        $response->assertViewIs('orders.show');

        $response = $this->get('/orders/order-id/edit');
        $response->assertViewIs('orders.edit');
    }

    /**
     * An order can be inserted into the database
     *
     * @test
     */
    function an_order_can_be_inserted_into_the_database()
    {
        $order = factory('App\Order')->create();
        $this->assertDatabaseHas('orders', ['reference' => $order->reference]);
    }
}
