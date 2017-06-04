<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewsTest extends TestCase
{
    /**
     * Index view is available
     *
     * @test
     */
    function index_view_is_available()
    {
        $response = $this->get('/');
        $response->assertViewIs('pages.index');
    }

    /**
     * Login view is available
     *
     * @test
     */
    function login_view_is_available()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }
    
    /**
     * Register view is available
     * 
     * @test
     */
    function register_view_is_available()
    {
        $response = $this->get('/register');
        $response->assertViewIs('auth.register');
    }
    
    /**
     * Password reset request view is available
     * 
     * @test
     */
    function password_reset_request_view_is_available()
    {
        $response = $this->get('/password/reset');
        $response->assertViewIs('auth.passwords.email');
    }
    
    /**
     * Password reset change view is available
     * 
     * @test
     */
    function password_reset_change_view_is_available()
    {
        $response = $this->get('/password/reset/{token}');
        $response->assertViewIs('auth.passwords.reset');
    }

    /**
     * Admin dashboard is available
     *
     * @test
     */
    function admin_dashboard_is_available()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertViewIs('admin.dashboard');
    }
}
