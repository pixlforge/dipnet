<?php

namespace Tests\Feature;

use App\Delivery;
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
        $this->signIn();

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
        $this->signIn();

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
        $this->signIn();

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
        $this->signIn();

        $response = $this->get('/deliveries/' . $this->delivery->id . '/edit');

        $response->assertViewIs('deliveries.edit');
    }

    /**
     * Authorized users can create deliveries
     * 
     * @test
     */
    function authorized_users_can_create_deliveries()
    {
        $this->signIn();

        $delivery = factory('App\Delivery')->make();

        $this->post("/deliveries", $delivery->toArray())
            ->assertRedirect('/deliveries');
    }

    /**
     * Authorized users can update deliveries
     *
     * @test
     */
    function authorized_users_can_update_deliveries()
    {
        $this->signIn();

        $delivery = factory('App\Delivery')->create();

        $delivery->interal_comment = "Hello World";

        $this->put("/deliveries/{$delivery->id}", $delivery->toArray())
            ->assertRedirect('/deliveries');
    }

    /**
     * Authorized users can delete deliveries
     *
     * @test
     */
    function authorized_users_can_delete_deliveries()
    {
        $this->signIn();

        $delivery = factory('App\Delivery')->create()->id;

        $this->delete("/deliveries/{$delivery}")
            ->assertRedirect('/deliveries');
    }
    
    /**
     * Authorized users can restore a delivery
     * 
     * @test
     */
    function authorized_users_can_restore_a_delivery()
    {
        $this->signIn();

        $delivery = factory('App\Delivery')->create();

        $this->delete("/deliveries/{$delivery->id}")
            ->assertRedirect('/deliveries');

        $this->put("/deliveries/{$delivery->id}/restore", $delivery->toArray())
            ->assertRedirect('/deliveries');
    }


}
