<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function members_without_an_avatar_are_assigned_a_random_one()
    {
        $user = factory('App\User')->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        if (!auth()->user()->avatarPath()) {
            $avatar = auth()->user()->randomAvatar();
        }

        $this->assertNotNull($avatar);
    }
}
