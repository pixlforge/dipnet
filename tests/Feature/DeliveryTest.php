<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeliveryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Delivery views are available
     *
     * @test
     */
    function delivery_views_are_available()
    {
        $response = $this->get('/deliveries');
        $response->assertViewIs('deliveries.index');

        $response = $this->get('/deliveries/create');
        $response->assertViewIs('deliveries.create');

        $response = $this->get('/deliveries/delivery-id');
        $response->assertViewIs('deliveries.show');

        $response = $this->get('/deliveries/delivery-id/edit');
        $response->assertViewIs('deliveries.edit');
    }

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
