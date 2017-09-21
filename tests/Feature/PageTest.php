<?php

namespace Tests\Feature;

use Tests\TestCase;

class PageTest extends TestCase
{
    /** @test */
    function login_view_is_available()
    {
        $response = $this->get('/login');

        $response->assertViewIs('auth.login');
    }

    /** @test */
    function register_view_is_available()
    {
        $response = $this->get('/register');

        $response->assertViewIs('auth.register');
    }

    /** @test */
    function password_reset_request_view_is_available()
    {
        $response = $this->get('/password/reset');

        $response->assertViewIs('auth.passwords.email');
    }

    /** @test */
    function password_reset_change_view_is_available()
    {
        $response = $this->get('/password/reset/{token}');

        $response->assertViewIs('auth.passwords.reset');
    }
}
