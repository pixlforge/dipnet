<?php

namespace Tests\Feature\Register;

use App\User;
use Tests\TestCase;
use App\Invitation;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_of_a_company_can_send_invitations_by_email()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->json('POST', route('invitation.store'), [
            'email' => 'johndoe@example.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('invitations', [
            'email' => 'johndoe@example.com',
            'company_id' => $user->company_id
        ]);

        Mail::assertQueued(InvitationEmail::class);
    }

    /** @test */
    public function cannot_invite_using_a_registered_email_address()
    {
        $this->withExceptionHandling();

        Mail::fake();

        $user = factory(User::class)->create(['email' => 'johndoe@example.com']);
        $this->signIn($user);

        // Invite someone using the same email address
        $this->json('POST', route('invitation.store'), [
            'email' => 'johndoe@example.com'
        ])->assertStatus(422);

        $this->assertDatabaseMissing('invitations', [
            'email' => 'johndoe@example.com'
        ]);
    }

    /** @test */
    public function it_should_contain_the_name_of_the_user_who_created_the_invitation()
    {
        Mail::fake();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $this->json('POST', route('invitation.store'), [
            'email' => 'janedoe@example.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('invitations', [
            'email' => 'janedoe@example.com',
            'created_by' => 'John Doe'
        ]);
    }

    /** @test */
    public function it_can_resend_invitations()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $this->postJson(route('invitation.store'), [
            'email' => 'johndoe@example.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('invitations', [
            'email' => 'johndoe@example.com',
            'company_id' => $user->company_id
        ]);

        $invitation = Invitation::where('email', 'johndoe@example.com')->first();

        $this->putJson(route('invitation.update'), [
            'email' => $invitation->email
        ])->assertStatus(200);

        Mail::assertQueued(InvitationEmail::class);
    }

    /** @test */
    public function an_invitation_can_be_cancelled()
    {
        Mail::fake();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $response = $this->postJson(route('invitation.store'), [
            'email' => 'janedoe@example.com'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('invitations', [
            'email' => 'janedoe@example.com'
        ]);
        Mail::assertQueued(InvitationEmail::class);

        $invitation = Invitation::whereEmail('janedoe@example.com')->first();

        $this->deleteJson(route('invitation.destroy', $invitation))
            ->assertStatus(204);

        $this->assertDatabaseMissing('invitations', [
            'email' => 'janedoe@example.com'
        ]);
        $this->assertEquals(0, Invitation::all()->count());
    }
}
