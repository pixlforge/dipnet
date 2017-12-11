<?php

namespace Tests\Feature\Profile;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_have_a_profile()
    {
        $this->signIn();

        $this->get("/profile")
            ->assertViewIs('profiles.profile');
    }

    /** @test */
    function an_authenticated_user_can_modify_his_profile()
    {
        $this->signIn();

        $this->get('/profile')
            ->assertSee('Profil');
    }
}
