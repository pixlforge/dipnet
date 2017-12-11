<?php

namespace Tests\Feature\Register;

use Dipnet\User;
use Dipnet\Contact;
use Dipnet\Company;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Dipnet\Mail\RegistrationEmailConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestsCanRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    function guests_can_reach_the_register_view()
    {
        $this->get(route('register.index'))
            ->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    /** @test */
    function guests_can_register_a_new_account()
    {
        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }

    /** @test */
    function a_confirmation_email_is_sent_upon_registration()
    {
        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        Mail::assertQueued(RegistrationEmailConfirmation::class);
    }

    /** @test */
    function an_associated_contact_can_be_created_after_registering_a_new_account()
    {
        $user = factory(User::class)
            ->states('not-confirmed')
            ->create(['email' => 'johndoe@example.com']);
        $this->signIn($user);

        // Post contact info
        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
            'email' => 'johndoe@example.com',
            'user_id' => 1
        ]);
    }

    /** @test */
    function an_associated_company_can_be_created_after_registering_a_new_account()
    {
        $user = factory(User::class)
            ->states('not-confirmed')
            ->create(['email' => 'johndoe@example.com']);
        $this->signIn($user);

        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
            'email' => 'johndoe@example.com',
            'user_id' => 1
        ]);

        $this->json('POST', route('register.company.store'), [
            'name' => 'The Night\'s Watch'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'The Night\'s Watch'
        ]);
    }

    /** @test */
    function a_newly_registered_user_should_be_associated_with_the_company_he_created()
    {
        $user = factory(User::class)
            ->states(['not-confirmed', 'no-company'])
            ->create(['email' => 'johndoe@example.com']);
        $this->signIn($user);

        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
            'email' => 'johndoe@example.com',
            'user_id' => 1
        ]);

        $this->json('POST', route('register.company.store'), [
            'name' => 'The Night\'s Watch'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'The Night\'s Watch'
        ]);

        $this->assertDatabaseHas('users', [
            'company_id' => 1
        ]);
    }

    /** @test */
    function a_newly_registered_users_contact_should_be_associated_with_the_company_he_created()
    {
        $user = factory(User::class)
            ->states(['not-confirmed', 'no-company'])
            ->create(['email' => 'johndoe@example.com']);
        $this->signIn($user);

        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
            'email' => 'johndoe@example.com',
            'user_id' => 1
        ]);

        $this->json('POST', route('register.company.store'), [
            'name' => 'The Night\'s Watch'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'The Night\'s Watch'
        ]);

        $this->assertDatabaseHas('users', [
            'company_id' => 1
        ]);

        $this->assertDatabaseHas('contacts', [
            'company_id' => 1
        ]);
    }

    /** @test */
    function it_redirects_the_user_if_account_contact_is_not_confirmed()
    {
        $user = factory(User::class)
            ->states('contact-not-confirmed')
            ->create();

        $this->actingAs($user);

        $this->get(route('index'))->assertRedirect(route('account.contact'));
    }

    /** @test */
    function a_user_without_any_associated_contact_can_add_a_contact()
    {
        $user = factory(User::class)
            ->states('contact-not-confirmed')
            ->create(['email' => 'johndoe@example.com']);

        $this->signIn($user);

        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'zip' => '10100',
            'city' => 'Castle Black',
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'zip' => '10100',
            'city' => 'Castle Black',
            'email' => 'johndoe@example.com',
            'user_id' => 1
        ]);
    }

    /** @test */
    function it_redirects_the_user_if_account_company_is_not_confirmed()
    {
        $user = factory(User::class)
            ->states(['company-not-confirmed', 'no-company'])
            ->create(['email' => 'johndoe@example.com']);

        $this->signIn($user);

        $this->get(route('index'))->assertRedirect(route('account.company'));
    }

    /** @test */
    function a_user_can_register_as_self()
    {
        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);

        $this->json('POST', route('register.contact-only.store'), [
            'name' => 'Home',
            'address_line1' => 'Main Street',
            'zip' => '10100',
            'city' => 'Moscow'
        ])->assertStatus(200);

        $this->assertNull(auth()->user()->hasCompany());
        $this->get(route('index'))->assertStatus(200);
    }

    /** @test */
    function users_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post(route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $user = User::whereEmail('johndoe@example.com')->firstOrFail();

        $this->assertFalse($user->isConfirmed());
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
            ->assertRedirect(route('profile.index'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->isConfirmed());
            $this->assertNull($user->confirmation_token);
        });
    }

    /** @test */
    function registering_using_an_existing_company_name_should_fail()
    {
        $this->withExceptionHandling();

        Mail::fake();

        // John Doe's account is created.
        $this->post(route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        // John Doe's contact is created.
        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'zip' => '10100',
            'city' => 'Castle Black',
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'zip' => '10100',
            'city' => 'Castle Black',
            'email' => 'johndoe@example.com',
            'user_id' => 1
        ]);

        // John Doe's company is created.
        $this->json('POST', route('register.company.store'), [
            'name' => 'The Night\'s Watch'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'The Night\'s Watch'
        ]);

        // Logout John Doe.
        $this->get('/logout');

        // Jane Doe's account is created.
        $this->json('POST', route('register.store'), [
            'username' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertStatus(200);

        // Jane Doe's contact is created
        $this->json('POST', route('register.contact.store'), [
            'name' => 'Winterfell',
            'address_line1' => 'Lord Stark\'s Quarters',
            'zip' => '10100',
            'city' => 'Winterfell'
        ])->assertStatus(200);

        // Jane Doe then tries to enter an existing company name.
        $this->json('POST', route('register.company.store'), [
            'name' => 'The Night\'s Watch'
        ])->assertStatus(422);
    }

    /** @test */
    function confirmation_email_can_be_sent_again()
    {
        Mail::fake();

        // Create the unconfirmed user
        $user = factory(User::class)->states('email-not-confirmed')->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $tokenBefore = $user->confirmation_token;

        // Send confirmation email again
        $this->putJson(route('register.confirm.update'))->assertStatus(200);

        // Assert confirmation token was updated
        $this->assertNotEquals($tokenBefore, $user->fresh()->confirmation_token);
        Mail::assertQueued(RegistrationEmailConfirmation::class);
    }
}
