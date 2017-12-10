<?php

namespace Tests\Feature;

use Dipnet\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function members_without_an_avatar_are_assigned_a_random_one()
    {
        $user = factory(User::class)->create([
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
