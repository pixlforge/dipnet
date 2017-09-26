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

    /** @test */
    function delivery_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/deliveries');

        $response->assertViewIs('deliveries.index');
    }

    /** @test */
    function authorized_users_can_create_deliveries()
    {
        $this->signIn(null, 'administrateur');

        $delivery = factory('App\Delivery')->make();

//        dd($delivery->toArray());

        $this->post(route('deliveries.store'), $delivery->toArray())
            ->assertRedirect(route('deliveries.index'));
    }

    /** @test */
    function authorized_users_can_update_deliveries()
    {
        $this->signIn(null, 'administrateur');

        $delivery = factory('App\Delivery')->create();

        $delivery->interal_comment = "Hello World";

        $this->put("/deliveries/{$delivery->id}", $delivery->toArray())
            ->assertRedirect('/deliveries');
    }

    /** @test */
    function authorized_users_can_delete_deliveries()
    {
        $this->signIn(null, 'administrateur');

        $delivery = factory('App\Delivery')->create()->id;

        $this->delete("/deliveries/{$delivery}")
            ->assertRedirect('/deliveries');
    }
}