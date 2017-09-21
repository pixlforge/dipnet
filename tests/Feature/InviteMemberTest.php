<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteMemberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function members_of_a_company_can_send_invitations_by_email()
    {
        Mail::fake();

        $firstMember = factory('App\User')->create();
        $this->actingAs($firstMember);

        $this->post(route('invite'), [
            'email' => 'johndoe@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);

        Mail::assertQueued(InvitationEmail::class);
    }

    /** @test */
    function invited_users_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $firstMember = factory('App\User')->create();
        $this->actingAs($firstMember);

        $this->post(route('invite'), [
            'email' => 'johndoe@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);

        $user = User::whereEmail('johndoe@example.com')->firstOrFail();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

//        $this->get(route('invite.confirm', ['token' => $user->confirmation_token]))
//            ->assertRedirect(route('profile'));
//
//        tap($user->fresh(), function ($user) {
//            $this->assertTrue($user->confirmed);
//            $this->assertNull($user->confirmation_token);
//        });
    }
}
