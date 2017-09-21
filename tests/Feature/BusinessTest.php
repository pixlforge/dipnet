<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a Business for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();

        return $this->business = factory('App\Business')->create();
    }

    /** @test */
    function business_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/businesses');

        $response->assertViewIs('businesses.index');
    }

    /** @test */
    function authorized_users_can_create_businesses()
    {
        $this->signIn(null, 'administrateur');

        $business = factory('App\Business')->make();

        $this->post('/businesses', $business->toArray())
            ->assertRedirect('/businesses');
    }

    /** @test */
    function authorized_users_can_update_businesses()
    {
        $this->signIn(null, 'administrateur');

        $business = factory('App\Business')->create();

        $business->description = 'Thank you Mario.';

        $this->put("/businesses/{$business->id}", $business->toArray())
            ->assertRedirect('/businesses');
    }

    /** @test */
    function authorized_users_can_delete_businesses()
    {
        $this->signIn(null, 'administrateur');

        $business = factory('App\Business')->create();

        $this->assertDatabaseHas('businesses', ['id' => $business->id]);

        $this->delete("/businesses/{$business->id}")
            ->assertRedirect('/businesses');
    }

    /** @test */
    function authorized_users_can_restore_businesses()
    {
        $this->signIn(null, 'administrateur');

        $business = factory('App\Business')->create();

        $this->assertDatabaseHas('businesses', ['id' => $business->id]);

        $this->delete("/businesses/{$business->id}")
            ->assertRedirect('/businesses');

        $this->put("/businesses/{$business->id}/restore", $business->toArray())
            ->assertRedirect('/businesses');
    }
}

















