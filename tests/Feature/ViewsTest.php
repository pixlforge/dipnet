<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewsTest extends TestCase
{
    /**
     * Homepage view is available
     * 
     * @test
     */
    function homepage_view_is_available()
    {
        $response = $this->get('/');
        $response->assertViewIs('welcome');
    }

    /**
     * Index view is available
     *
     * @test
     */
    function index_view_is_available()
    {
        $response = $this->get('/index');
        $response->assertViewIs('pages.index');
    }
}
