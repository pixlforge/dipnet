<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Admin dashboard is available
     *
     * @test
     */
    function admin_dashboard_is_available()
    {
        $this->signIn();
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
    }
}
