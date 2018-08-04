<?php

namespace Tests\Feature\Contact;

use App\User;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Company;

class CreateContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_new_admin_contacts()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
            'company_id' => $company->id,
        ]);
        $response->assertOk();
        $this->assertCount(1, Contact::all());
    }

    /** @test */
    public function users_cannot_create_new_admin_contacts()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertForbidden();
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function guests_cannot_create_new_admin_contacts()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertRedirect(route('login'));
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => '',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => str_repeat('a', 2),
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => str_repeat('a', 46),
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_1_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => '',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_1_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 123,
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_1_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => str_repeat('a', 2),
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_1_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => str_repeat('a', 256),
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_2_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 123,
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_2_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => str_repeat('a', 2),
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_address_line_2_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => str_repeat('a', 256),
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_zip_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_zip_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => 123,
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_zip_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => str_repeat('a', 3),
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_zip_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => str_repeat('a', 17),
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_city_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => '',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_city_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 123,
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_city_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => str_repeat('a', 1),
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_city_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => str_repeat('a', 256),
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_phone_number_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => 123,
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('phone_number');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_phone_number_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => str_repeat('a', 256),
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('phone_number');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_fax_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => 123,
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('fax');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_fax_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => str_repeat('a', 256),
            'email' => 'derry@example.com',
        ]);
        $response->assertJsonValidationErrors('fax');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_email_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => '',
        ]);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_email_format_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example',
        ]);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_email_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => str_repeat('a', 244) . '@example.com',
        ]);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_creation_validation_fails_if_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('admin.contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
            'company_id' => 999,
        ]);
        $response->assertJsonValidationErrors('company_id');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function users_associated_with_a_company_can_create_user_contacts()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertOk();
        $this->assertCount(1, Contact::all());

        $contact = Contact::first();
        $this->assertEquals($company->id, $contact->company->id);
        $this->assertNull($contact->user);
    }

    /** @test */
    public function solo_users_can_create_user_contacts()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertOk();
        $this->assertCount(1, Contact::all());

        $contact = Contact::first();
        $this->assertEquals($user->id, $contact->user->id);
        $this->assertNull($contact->company);
    }

    /** @test */
    public function guests_cannot_create_new_user_contacts()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertStatus(401);
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => '',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 123,
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => str_repeat('a', 2),
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => str_repeat('a', 46),
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_1_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => '',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_1_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 123,
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_1_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => str_repeat('a', 2),
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_1_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => str_repeat('a', 256),
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_2_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 123,
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_2_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => str_repeat('a', 2),
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_address_line_2_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => str_repeat('a', 256),
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_zip_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_zip_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => 123,
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_zip_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => str_repeat('1', 3),
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_zip_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => str_repeat('1', 17),
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_city_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => '',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_city_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 123,
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_city_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => str_repeat('a', 1),
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_city_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => str_repeat('a', 256),
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_phone_number_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => 123,
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('phone_number');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_phone_number_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => str_repeat('a', 256),
            'fax' => '0123456789',
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('phone_number');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_fax_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => 123,
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('fax');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_fax_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => str_repeat('1', 256),
            'email' => 'derry@example.com',
        ]);

        $response->assertJsonValidationErrors('fax');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_email_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => '',
        ]);

        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_email_format_is_invalid()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example',
        ]);

        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function store_user_contact_validation_fails_if_email_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Contact::all());

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => str_repeat('a', 244) . '@example.com',
        ]);

        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }
}
