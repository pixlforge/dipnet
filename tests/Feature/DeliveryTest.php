<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

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
        $this->signIn(null, 'administrateur');

        $response = $this->get('/deliveries');

        $response->assertViewIs('deliveries.index');
    }

    /**
     * Authorized users can create deliveries
     * 
     * @test
     */
    function authorized_users_can_create_deliveries()
    {
        $this->signIn(null, 'administrateur');

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
        $this->signIn(null, 'administrateur');

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
        $this->signIn(null, 'administrateur');

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
        $this->signIn(null, 'administrateur');

        $delivery = factory('App\Delivery')->create();

        $this->delete("/deliveries/{$delivery->id}")
            ->assertRedirect('/deliveries');

        $this->put("/deliveries/{$delivery->id}/restore", $delivery->toArray())
            ->assertRedirect('/deliveries');
    }


}
