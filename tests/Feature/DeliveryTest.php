<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeliveryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A delivery can be inserted into the database
     *
     * @test
     */
    function a_delivery_can_be_inserted_into_the_database()
    {
        $delivery = factory('App\Delivery')->create();
        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id]);
    }
}
