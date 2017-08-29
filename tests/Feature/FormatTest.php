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
     * Create a Format for all tests to use.
     *
     * @return mixed
     */
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
        $this->signIn(null, 'administrateur');

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
        $this->signIn(null, 'administrateur');

        $response = $this->get('/formats/create');

        $response->assertViewIs('formats.create');
    }

    /**
     * Authorized users can create formats
     *
     * @test
     */
    function authorized_users_can_create_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->make();

        $this->post('/formats', $format->toArray())
            ->assertRedirect('/formats');
    }
    
    /**
     * Authorized users can update formats
     * 
     * @test
     */
    function authorized_users_can_update_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->create();

        $format->name = 'Super Format';

        $this->put("/formats/{$format->id}", $format->toArray())
            ->assertRedirect('/formats');
    }

    /**
     * Authorized users can delete formats
     *
     * @test
     */
    function authorized_users_can_delete_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->create();

        $this->delete("/formats/{$format->id}")
            ->assertRedirect('formats');
    }

    /**
     * Authorized users can restore formats
     *
     * @test
     */
    function authorized_users_can_restore_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->create();

        $this->delete("/formats/{$format->id}")
            ->assertRedirect('formats');

        $this->put("/formats/{$format->id}/restore", [$format])
            ->assertRedirect('formats');
    }
}