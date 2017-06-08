<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessTest extends TestCase
{
    use DatabaseTransactions;

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
        $response = $this->get('/businesses/create');
        $response->assertViewIs('businesses.create');
    }

    /**
     * Business show view is available and requires a business
     *
     * @test
     */
    function business_show_view_is_available_and_requires_a_business()
    {
        $response = $this->get('/businesses/' . $this->business->name);
        $response->assertViewIs('businesses.show');
    }

    /**
     * Business edit view is available and requires a business
     *
     * @test
     */
    function business_edit_view_is_available_and_requires_a_business()
    {
        $response = $this->get('/businesses/' . $this->business->name . '/edit');
        $response->assertViewIs('businesses.edit');
    }
}

















