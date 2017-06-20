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
    function admin_dashboard_is_available_and_only_admins_can_access_it()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/admin/dashboard');

        $response->assertStatus(200);
    }
}
