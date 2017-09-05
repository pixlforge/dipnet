<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Tests\TestCase;
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
 * It redirects the user if account contact information is missing
 *
 * @test
 */
    function it_redirects_the_user_if_account_contact_information_is_missing()
    {
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

        $this->get(route('index'))
            ->assertRedirect(route('missingContact'));
    }

    /**
     * It redirects the user if account company information is missing
     *
     * @test
     */
    function it_redirects_the_user_if_account_company_information_is_missing()
    {
        $contact = factory('App\Contact')->create();

        $user = factory('App\User')->make([
            'username' => 'JohnDoe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'contact_id' => $contact->id,
            'company_id' => 1
        ]);

        $this->post(route('register'), $user->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => $user->username,
            'email' => $user->email,
            'contact_id' => 2,
            'company_id' => 1
        ]);

//        $user = User::where('id', 1)->first();
//
//        $this->actingAs($user);
//
//        $this->get(route('index'))
//            ->assertRedirect(route('missingCompany'));
    }
}
