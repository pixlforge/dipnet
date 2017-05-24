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
