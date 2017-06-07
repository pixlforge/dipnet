<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Format views are available
     *
     * @test
     */
    function format_views_are_available()
    {
        $response = $this->get('/formats');
        $response->assertViewIs('formats.index');

        $response = $this->get('/formats/create');
        $response->assertViewIs('formats.create');

        $response = $this->get('/formats/format-id');
        $response->assertViewIs('formats.show');

        $response = $this->get('/formats/format-id/edit');
        $response->assertViewIs('formats.edit');
    }

    /**
     * A format can be inserted into the database
     *
     * @test
     */
    function a_format_can_be_inserted_into_the_database()
    {
        $format = factory('App\Format')->create();
        $this->assertDatabaseHas('formats', ['name' => $format->name]);
    }

    /**
     * A format can be posted
     *
     * @test
     */
    function a_format_can_be_posted()
    {
        $format = factory('App\Format')->make();


    }

}
