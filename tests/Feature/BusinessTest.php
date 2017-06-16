<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessTest extends TestCase
{
    use DatabaseMigrations;

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

    /**
     * Business index view is available
     *
     * @test
     */
    function business_index_view_is_available()
    {
        $this->signIn();

        $response = $this->get('/businesses');

        $response->assertViewIs('businesses.index');
    }

    /**
     * Business create view is available
     *
     * @test
     */
    function business_create_view_is_available()
    {
        $this->signIn();

        $response = $this->get('/businesses/create');

        $response->assertViewIs('businesses.create');
    }

    /**
     * Business edit view is available and requires a business
     *
     * @test
     */
    function business_edit_view_is_available_and_requires_a_business()
    {
        $this->signIn();

        $response = $this->get('/businesses/' . $this->business->id . '/edit');

        $response->assertViewIs('businesses.edit');
    }

    /**
     * Authorized users can create businesses
     *
     * @test
     */
    function authorized_users_can_create_businesses()
    {
        $this->signIn();

        $business = factory('App\Business')->make();

        $this->post('/businesses', $business->toArray())
            ->assertRedirect('/businesses');
    }

    /**
     * Authorized users can update businesses
     *
     * @test
     */
    function authorized_users_can_update_businesses()
    {
        $this->signIn();

        $business = factory('App\Business')->create();

        $business->description = 'Thank you Mario.';

        $this->put("/businesses/{$business->id}", $business->toArray())
            ->assertRedirect('/businesses');
    }

    /**
     * Authorized users can delete businesses
     *
     * @test
     */
    function authorized_users_can_delete_businesses()
    {
        $this->signIn();

        $business = factory('App\Business')->create();

        $this->assertDatabaseHas('businesses', ['id' => $business->id]);

        $this->delete("/businesses/{$business->id}")
            ->assertRedirect('/businesses');
    }

    /**
     * Authorized users can restore businesses
     *
     * @test
     */
    function authorized_users_can_restore_businesses()
    {
        $this->signIn();

        $business = factory('App\Business')->create();

        $this->assertDatabaseHas('businesses', ['id' => $business->id]);

        $this->delete("/businesses/{$business->id}")
            ->assertRedirect('/businesses');

        $this->put("/businesses/{$business->id}/restore", $business->toArray())
            ->assertRedirect('/businesses');
    }
}

















