<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmailConfirmation;
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
        $user = factory('App\User')
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
        $user = factory('App\User')
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
        $user = factory('App\User')
            ->states(['not-confirmed', 'no-company'])
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
        $user = factory('App\User')
            ->states(['not-confirmed', 'no-company'])
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
//    function it_redirects_the_user_if_account_contact_is_not_confirmed()
//    {
//        $user = factory('App\User')->states('contact-not-confirmed')->create();
//
//        $this->actingAs($user);
//
//        $this->get(route('index'))
//            ->assertRedirect(route('account.contact'));
//
//        $user->update([
//            'contact_confirmed' => true,
//            'company_confirmed' => true
//        ]);
//
//        $this->get(route('index'))
//            ->assertStatus(200);
//    }

    /** @test */
//    function it_redirects_the_user_if_account_company_is_not_confirmed()
//    {
//        $user = factory('App\User')->states('company-not-confirmed')->create([
//            'contact_confirmed' => true
//        ]);
//
//        $this->actingAs($user);
//
//        $this->get(route('index'))
//            ->assertRedirect(route('account.company'));
//
//        $user->update([
//            'company_confirmed' => true
//        ]);
//
//        $this->get(route('index'))
//            ->assertStatus(200);
//    }

    /** @test */
//    function users_can_fully_confirm_their_email_addresses()
//    {
//        Mail::fake();
//
//        $this->post(route('register'), [
//            'username' => 'John Doe',
//            'email' => 'johndoe@example.com',
//            'password' => 'secret',
//            'password_confirmation' => 'secret',
//        ]);
//
//        $user = User::whereEmail('johndoe@example.com')->firstOrFail();
//
//        $this->assertFalse($user->isConfirmed());
//        $this->assertNotNull($user->confirmation_token);
//
//        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
//            ->assertRedirect(route('profile'));
//
//        tap($user->fresh(), function ($user) {
//            $this->assertTrue($user->isConfirmed());
//            $this->assertNull($user->confirmation_token);
//        });
//    }

    /** @test */
//    function registering_using_an_existing_company_name_should_fail()
//    {
//        Mail::fake();
//
//        // First user creates an account and sets his company name to Xerox.
//        $this->post(route('register'), [
//            'username' => 'John Doe',
//            'email' => 'johndoe@example.com',
//            'password' => 'secret',
//            'password_confirmation' => 'secret'
//        ]);
//
//        $this->assertDatabaseHas('users', [
//            'username' => 'John Doe',
//            'email' => 'johndoe@example.com',
//        ]);
//
//        $firstUser = User::whereEmail('johndoe@example.com')->firstOrFail();
//        $firstUserCompany = Company::whereId($firstUser->company_id)->firstOrFail();
//        $firstUserCompany->name = 'Xerox';
//        $firstUserCompany->save();
//
//        // Log out so we can create another account.
//        $this->get('/logout');
//
//        // Second user creates an account and tries to his company name to Xerox.
//        $this->post(route('register'), [
//            'username' => 'Jane Doe',
//            'email' => 'janedoe@example.com',
//            'password' => 'secret',
//            'password_confirmation' => 'secret'
//        ]);
//
//        $this->assertDatabaseHas('users', [
//            'username' => 'Jane Doe',
//            'email' => 'janedoe@example.com',
//        ]);
//
//        $secondUser = User::whereEmail('janedoe@example.com')->firstOrFail();
//        $secondUserCompany = Company::whereId($secondUser->company_id)->firstOrFail();
//        $secondUserCompany->name = 'Xerox';
//        $secondUserCompany->save();
//    }
}
