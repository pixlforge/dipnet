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
        $this->signIn(null, 'administrateur');

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
        $this->signIn(null, 'administrateur');

        $response = $this->get('/orders/create');

        $response->assertViewIs('orders.create');
    }

    /**
     * Order edit view is available and requires an order
     *
     * @test
     */
    function order_edit_view_is_available_and_requires_an_order()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/orders/' . $this->order->id . '/edit');

        $response->assertViewIs('orders.edit');
    }

    /**
     * Authorized users can create orders
     *
     * @test
     */
    function authorized_users_can_create_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->make();

        $this->post('/orders', $order->toArray())
            ->assertRedirect('/orders');
    }

    /**
     * Authorized users can update order
     *
     * @test
     */
    function authorized_users_can_update_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->create(['status' => 'nok']);

        $order->status = 'ok';

        $this->put("/orders/{$order->id}", $order->toArray())
            ->assertRedirect('/orders');
    }

    /**
     * Authorized users can delete orders
     *
     * @test
     */
    function authorized_users_can_delete_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->create();

        $this->assertDatabaseHas('orders', ['id' => $order->id]);

        $this->delete("/orders/{$order->id}")
            ->assertRedirect('/orders');
    }

    /**
     * Authorized users can restore orders
     *
     * @test
     */
    function authorized_users_can_restore_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->create();

        $this->assertDatabaseHas('orders', ['id' => $order->id]);

        $this->delete("/orders/{$order->id}")
            ->assertRedirect('/orders');

        $this->put("/orders/{$order->id}/restore", [$order])
            ->assertRedirect('/orders');
    }
}
