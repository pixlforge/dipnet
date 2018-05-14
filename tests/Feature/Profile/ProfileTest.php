<?php

namespace Tests\Feature\Profile;

use App\User;
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
    function an_authenticated_user_can_update_his_own_profile()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $this->patchJson(route('account.update', $user), [
            'email' => 'john_doe@example.com'
        ])->assertStatus(200);

        $user = User::where('email', 'john_doe@example.com')->first();
        $this->assertCount(1, $user);
    }
}
