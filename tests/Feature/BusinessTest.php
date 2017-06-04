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
     * Business views are available
     *
     * @test
     */
    function business_views_are_available()
    {
        $response = $this->get('/businesses');
        $response->assertViewIs('businesses.index');

        $response = $this->get('/businesses/create');
        $response->assertViewIs('businesses.create');

        $response = $this->get('/businesses/business-id');
        $response->assertViewIs('businesses.show');

        $response = $this->get('/businesses/business-id/edit');
        $response->assertViewIs('businesses.edit');
    }

    /**
     * A business can be inserted into the database
     *
     * @test
     */
    function a_business_can_be_inserted_into_the_database()
    {
        $business = factory('App\Business')->create();
        $this->assertDatabaseHas('businesses', ['id' => $business->id]);
    }
}
