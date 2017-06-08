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
     * Create an Order for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();
        return $this->order = factory('App\Order')->create();
    }

    /**
     * Order index view is available
     *
     * @test
     */
    function order_index_view_available()
    {
        $response = $this->get('/orders');
        $response->assertViewIs('orders.index');
    }

    /**
     * Order create view is available
     *
     * @test
     */
    function order_create_view_is_available()
    {
        $response = $this->get('/orders/create');
        $response->assertViewIs('orders.create');
    }

    /**
     * Order show view is available and requires an order
     *
     * @test
     */
    function order_show_view_is_available_and_requires_an_order()
    {
        $response = $this->get('/orders/' . $this->order->reference);
        $response->assertViewIs('orders.show');
    }

    /**
     * Order edit view is available and requires an order
     *
     * @test
     */
    function order_edit_view_is_available_and_requires_an_order()
    {
        $response = $this->get('/orders/' . $this->order->reference . '/edit');
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
