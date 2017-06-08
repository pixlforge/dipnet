<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        return $this->format = factory('App\Format')->create();
    }

    /**
     * Format index view is available
     *
     * @test
     */
    function format_index_view_is_available()
    {
        $response = $this->get('/formats');
        $response->assertViewIs('formats.index');
    }

    /**
     * Format create view is available
     *
     * @test
     */
    function format_create_view_is_available()
    {
        $response = $this->get('/formats/create');
        $response->assertViewIs('formats.create');
    }

    /**
     * Format show view is available
     *
     * @test
     */
    function format_show_view_is_available()
    {
        $response = $this->get('/formats/' . $this->format->name);
        $response->assertViewIs('formats.show');
    }

    /**
     * Format edit view is available
     *
     * @test
     */
    function format_edit_view_is_available()
    {
        $response = $this->get('/formats/' . $this->format->name . '/edit');
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
//    function a_format_can_be_posted()
//    {
//        $response = $this->post($this->format);
//        dd($response);
//    }

}
