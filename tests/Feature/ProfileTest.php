<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Authenticated users have a profile
     * 
     * @test
     */
    function authenticated_users_have_a_profile()
    {
        $this->signIn();

        $this->get("/profile")
            ->assertViewIs('profiles.profile');
    }
}
