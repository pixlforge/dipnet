<?php

namespace Tests\Feature\Avatar;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_without_an_avatar_are_assigned_a_random_one()
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
