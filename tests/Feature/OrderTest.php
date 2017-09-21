<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    function order_index_view_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/orders');

        $response->assertViewIs('orders.index');
    }

    /** @test */
    function authorized_users_can_create_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->make();

        $this->post('/orders', $order->toArray())
            ->assertRedirect('/orders');
    }

    /** @test */
    function authorized_users_can_update_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->create(['status' => 'nok']);

        $order->status = 'ok';

        $this->put("/orders/{$order->id}", $order->toArray())
            ->assertRedirect('/orders');
    }

    /** @test */
    function authorized_users_can_delete_orders()
    {
        $this->signIn(null, 'administrateur');

        $order = factory('App\Order')->create();

        $this->assertDatabaseHas('orders', ['id' => $order->id]);

        $this->delete("/orders/{$order->id}")
            ->assertRedirect('/orders');
    }

    /** @test */
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