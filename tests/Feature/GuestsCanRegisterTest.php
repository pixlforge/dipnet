<?php

namespace Tests\Feature;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmailConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestsCanRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_can_reach_the_register_view()
    {
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    /** @test */
    function guests_can_register_a_new_account()
    {
        Mail::fake();

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

    /** @test */
    function it_redirects_the_user_if_account_contact_is_not_confirmed()
    {
        $user = factory('App\User')->states('contact-not-confirmed')->create();

        $this->actingAs($user);

        $this->get(route('index'))
            ->assertRedirect(route('account.contact'));

        $user->update([
            'contact_confirmed' => true,
            'company_confirmed' => true
        ]);

        $this->get(route('index'))
            ->assertStatus(200);
    }

    /** @test */
    function it_redirects_the_user_if_account_company_is_not_confirmed()
    {
        $user = factory('App\User')->states('company-not-confirmed')->create([
            'contact_confirmed' => true
        ]);

        $this->actingAs($user);

        $this->get(route('index'))
            ->assertRedirect(route('account.company'));

        $user->update([
            'company_confirmed' => true
        ]);

        $this->get(route('index'))
            ->assertStatus(200);
    }

    /** @test */
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

    /** @test */
    function users_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post(route('register'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $user = User::whereEmail('johndoe@example.com')->firstOrFail();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
            ->assertRedirect(route('profile'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });
    }

    /** @test */
    function registering_using_an_existing_company_name_should_fail()
    {
        Mail::fake();

        // First user creates an account and sets his company name to Xerox.
        $this->post(route('register'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $firstUser = User::whereEmail('johndoe@example.com')->firstOrFail();
        $firstUserCompany = Company::whereId($firstUser->company_id)->firstOrFail();
        $firstUserCompany->name = 'Xerox';
        $firstUserCompany->save();

        // Log out so we can create another account.
        $this->get('/logout');

        // Second user creates an account and tries to his company name to Xerox.
        $this->post(route('register'), [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
        ]);

        $secondUser = User::whereEmail('janedoe@example.com')->firstOrFail();
        $secondUserCompany = Company::whereId($secondUser->company_id)->firstOrFail();
        $secondUserCompany->name = 'Xerox';
        $secondUserCompany->save();
    }
}
