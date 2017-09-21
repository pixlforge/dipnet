<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormatTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    function format_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/formats');

        $response->assertViewIs('formats.index');
    }

    /** @test */
    function authorized_users_can_create_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->make();

        $this->post('/formats', $format->toArray())
            ->assertRedirect('/formats');
    }

    /** @test */
    function authorized_users_can_update_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->create();

        $format->name = 'Super Format';

        $this->put("/formats/{$format->id}", $format->toArray())
            ->assertRedirect('/formats');
    }

    /** @test */
    function authorized_users_can_delete_formats()
    {
        $this->signIn(null, 'administrateur');

        $format = factory('App\Format')->create();

        $this->delete("/formats/{$format->id}")
            ->assertRedirect('formats');
    }

    /** @test */
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