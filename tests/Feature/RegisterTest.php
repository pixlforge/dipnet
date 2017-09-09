<?php

namespace Tests\Feature;

use App\User;
use App\Contact;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Mail\RegistrationEmailConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Guests can reach the register view.
     * 
     * @test
     */
    function guests_can_reach_the_register_view()
    {
        // Guests can reach the register view
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    /**
     * Guests can register a new account
     *
     * @test
     */
    function guests_can_register_a_new_account()
    {
        // Given a guest registers a new account
        // Then, a default contact should be automatically created for this user,
        // Alongside a default company

        $user = factory('App\User')->make([
            'username' => 'JohnDoe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'contact_id' => 1,
            'company_id' => 1
        ]);

        $this->post(route('register'), $user->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => $user->username,
            'email' => $user->email,
            'contact_id' => 1,
            'company_id' => 1
        ]);
    }

    /**
     * It redirects the user if account contact information is not confirmed
     *
     * @test
     */
    function it_redirects_the_user_if_account_contact_is_not_confirmed()
    {
        $user = factory('App\User')->states('contact-not-confirmed')->create();

        $this->actingAs($user);

        $this->get(route('index'))
            ->assertRedirect(route('missingContact'));

        $user->update([
            'contact_confirmed' => true,
            'company_confirmed' => true
        ]);

        $this->get(route('index'))
            ->assertStatus(200);
    }

    /**
     * It redirects the user if account company information is not confirmed
     *
     * @test
     */
    function it_redirects_the_user_if_account_company_is_not_confirmed()
    {
        $user = factory('App\User')->states('company-not-confirmed')->create([
            'contact_confirmed' => true
        ]);

        $this->actingAs($user);

        $this->get(route('index'))
            ->assertRedirect(route('missingCompany'));

        $user->update([
            'company_confirmed' => true
        ]);

        $this->get(route('index'))
            ->assertStatus(200);
    }
    
    /**
     * A confirmation email is sent upon registration
     * 
     * @test
     */
    function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post(route('register'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        Mail::assertQueued(RegistrationEmailConfirmation::class);
    }
    
    /**
     * Users can fully confirm their email addresses
     * 
     * @test
     */
    function users_can_fully_confirm_their_email_addresses()
    {
        $this->post(route('register'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $user = User::whereEmail('johndoe@example.com')->firstOrFail();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $response = $this->get(route('register.confirm', ['token' => $user->confirmation_token]));

        $this->assertTrue($user->fresh()->confirmed);

        $response->assertRedirect(route('profile'));
    }
}
