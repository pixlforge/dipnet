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
