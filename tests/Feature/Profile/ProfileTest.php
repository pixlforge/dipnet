<?php

namespace Tests\Feature\Profile;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserUpdatedEmailAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_have_a_profile()
    {
        $this->signIn();

        $this->get('/profile')
            ->assertViewIs('profiles.profile');
    }

    /** @test */
    public function an_authenticated_user_can_update_his_own_profile()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $this->patchJson(route('account.update', $user), [
            'username' => 'John Doe',
            'email' => 'john_doe@example.com',
        ])->assertStatus(200);

        $user = User::where('email', 'john_doe@example.com')->get();
        $this->assertCount(1, $user);
    }

    /** @test */
    public function a_user_needs_to_reverify_his_account_if_they_update_their_email_address()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertTrue($user->email_confirmed);

        $response = $this->patchJson(route('account.update'), [
            'username' => 'John Doe',
            'email' => 'john@somethingelse.com',
        ]);

        $response->assertOk();

        $this->assertFalse($user->fresh()->email_confirmed);
        $this->assertNotNull($user->confirmation_token);

        Mail::assertQueued(UserUpdatedEmailAddress::class, function ($mail) use ($user) {
            return $mail->hasTo('john@somethingelse.com');
        });
    }
}
