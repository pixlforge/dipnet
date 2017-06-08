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
     * Create a Delivery for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();
        return $this->delivery = factory('App\Delivery')->create();
    }

    /**
     * Delivery index view is available
     *
     * @test
     */
    function delivery_index_view_is_available()
    {
        $response = $this->get('/deliveries');
        $response->assertViewIs('deliveries.index');
    }

    /**
     * Delivery create view is available
     *
     * @test
     */
    function delivery_create_view_is_available()
    {
        $response = $this->get('/deliveries/create');
        $response->assertViewIs('deliveries.create');
    }

    /**
     * Delivery show view is available and requires a delivery
     *
     * @test
     */
    function delivery_show_view_is_available_and_requires_a_delivery()
    {
        $response = $this->get('/deliveries/' . $this->delivery->id);
        $response->assertViewIs('deliveries.show');
    }

    /**
     * Delivery edit view is available and requires a delivery
     *
     * @test
     */
    function delivery_edit_view_is_available_and_requires_a_delivery()
    {
        $response = $this->get('/deliveries/' . $this->delivery->id . '/edit');
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
