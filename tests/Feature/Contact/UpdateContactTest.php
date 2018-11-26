<?php

namespace Tests\Feature\Contact;

use App\User;
use App\Contact;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_existing_admin_contacts()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertOk();

        $contact = $contact->fresh();
        $this->assertEquals('New contact first name', $contact->first_name);
        $this->assertEquals('New contact last name', $contact->last_name);
        $this->assertEquals('New contact company name', $contact->company_name);
        $this->assertEquals('New address line 1', $contact->address_line1);
        $this->assertEquals('New address line 2', $contact->address_line2);
        $this->assertEquals('2000', $contact->zip);
        $this->assertEquals('New city name', $contact->city);
        $this->assertEquals('22222222', $contact->phone_number);
        $this->assertEquals('newemail@example.com', $contact->email);
        $this->assertEquals('newCompany', $contact->company->name);
    }

    /** @test */
    public function users_cannot_update_existing_admin_contacts()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertForbidden();

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function guests_cannot_update_existing_admin_contacts()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertRedirect(route('login'));

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => '',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => str_repeat('a', 1),
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => str_repeat('a', 46),
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_1_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => '',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_1_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 123,
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_1_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => str_repeat('a', 2),
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_1_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => str_repeat('a', 256),
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_2_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 123,
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line2');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_2_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => str_repeat('a', 2),
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line2');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_address_line_2_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => str_repeat('a', 256),
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('address_line2');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_zip_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_zip_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => 123,
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_zip_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => str_repeat('1', 3),
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_zip_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => str_repeat('1', 17),
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_city_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => '',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_city_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 123,
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_city_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => str_repeat('a', 1),
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_city_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => str_repeat('a', 256),
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_phone_number_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => 123,
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('phone_number');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_phone_number_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('1', 256),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('phone_number');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_email_format_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => 'newemail@example',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('email');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_email_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);
        $newCompany = factory(Company::class)->create(['name' => 'newCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => str_repeat('a', 244) . '@example.com',
            'company_id' => $newCompany->id,
        ]);
        $response->assertJsonValidationErrors('email');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function admin_contact_update_validation_fails_if_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $oldCompany = factory(Company::class)->create(['name' => 'oldCompany']);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'company_id' => $oldCompany->id,
        ]);

        $response = $this->patchJson(route('admin.contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => str_repeat('2', 8),
            'fax' => str_repeat('2', 8),
            'email' => str_repeat('a', 244) . '@example.com',
            'company_id' => 999,
        ]);
        $response->assertJsonValidationErrors('company_id');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
        $this->assertEquals('oldCompany', $contact->company->name);
    }

    /** @test */
    public function users_can_update_their_own_contacts()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertOk();

        $contact = $contact->fresh();
        $this->assertEquals('New contact first name', $contact->first_name);
        $this->assertEquals('New contact last name', $contact->last_name);
        $this->assertEquals('New contact company name', $contact->company_name);
        $this->assertEquals('New address line 1', $contact->address_line1);
        $this->assertEquals('New address line 2', $contact->address_line2);
        $this->assertEquals('2000', $contact->zip);
        $this->assertEquals('New city name', $contact->city);
        $this->assertEquals('0123456789', $contact->phone_number);
        $this->assertEquals('newemail@example.com', $contact->email);
    }

    /** @test */
    public function users_cannot_update_others_contacts()
    {
        $this->withExceptionHandling();
        
        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $otherUser = factory(User::class)->states('user', 'solo')->create();

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $otherUser->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertForbidden();

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'name' => '',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'name' => 123,
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'name' => str_repeat('a', 2),
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'name' => str_repeat('a', 46),
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('first_name');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_1_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => '',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_1_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 123,
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_1_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => str_repeat('a', 2),
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_1_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => str_repeat('a', 256),
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line1');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_2_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 123,
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line2');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_2_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => str_repeat('a', 2),
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line2');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_address_line_2_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => str_repeat('a', 256),
            'zip' => '2000',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('address_line2');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_zip_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '',
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_zip_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => 123,
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_zip_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => str_repeat('1', 3),
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_zip_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => str_repeat('1', 17),
            'city' => 'New city name',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('zip');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_city_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => '',
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_city_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 123,
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_city_is_too_short()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => str_repeat('a', 1),
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_city_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => str_repeat('a', 256),
            'phone_number' => '0123456789',
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('city');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_phone_number_is_not_a_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New contact city',
            'phone_number' => 123,
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('phone_number');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_phone_number_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New contact city',
            'phone_number' => str_repeat('a', 256),
            'email' => 'newemail@example.com',
        ]);
        $response->assertJsonValidationErrors('phone_number');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_email_format_is_invalid()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New contact city',
            'phone_number' => '0123456789',
            'email' => 'newemail@address',
        ]);
        $response->assertJsonValidationErrors('email');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }

    /** @test */
    public function update_user_contact_validation_fails_if_email_format_is_too_long()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create([
            'first_name' => 'Old contact first name',
            'last_name' => 'Old contact last name',
            'company_name' => 'Old contact company name',
            'address_line1' => 'Old address line 1',
            'address_line2' => 'Old address line 2',
            'zip' => '1000',
            'city' => 'Old city name',
            'phone_number' => str_repeat('1', 8),
            'email' => 'oldemail@example.com',
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson(route('contacts.update', $contact), [
            'first_name' => 'New contact first name',
            'last_name' => 'New contact last name',
            'company_name' => 'New contact company name',
            'address_line1' => 'New address line 1',
            'address_line2' => 'New address line 2',
            'zip' => '2000',
            'city' => 'New contact city',
            'phone_number' => '0123456789',
            'email' => str_repeat('a', 244) . '@address.com',
        ]);
        $response->assertJsonValidationErrors('email');

        $contact = $contact->fresh();
        $this->assertEquals('Old contact first name', $contact->first_name);
        $this->assertEquals('Old contact last name', $contact->last_name);
        $this->assertEquals('Old contact company name', $contact->company_name);
        $this->assertEquals('Old address line 1', $contact->address_line1);
        $this->assertEquals('Old address line 2', $contact->address_line2);
        $this->assertEquals('1000', $contact->zip);
        $this->assertEquals('Old city name', $contact->city);
        $this->assertEquals('11111111', $contact->phone_number);
        $this->assertEquals('oldemail@example.com', $contact->email);
    }
}
