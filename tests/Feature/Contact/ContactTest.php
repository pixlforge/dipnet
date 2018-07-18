<?php

namespace Tests\Feature\Contact;

use App\User;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function contact_index_view_is_available()
    {
        $this->signIn();

        $response = $this->get(route('contacts.index'));

        $response->assertViewIs('contacts.index');
    }

    /** @test */
    public function authorized_users_can_create_contacts()
    {
        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com',
            'user_id' => $user->id,
            'company_id' => $user->company_id
        ]);
    }

    /** @test */
    public function user_contact_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function authorized_users_can_update_contacts()
    {
        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $this->postJson(route('contacts.store'), [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Derry',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);

        $contact = Contact::whereEmail('derry@example.com')->first();

        $this->putJson(route('contacts.update', $contact), [
            'name' => 'Borbet',
            'address_line1' => 'Le Borbet 23',
            'address_line2' => '',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'celien@pixlforge.ch'
        ])->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Borbet',
            'address_line1' => 'Le Borbet 23',
            'address_line2' => null,
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'celien@pixlforge.ch'
        ]);
    }

    /** @test */
    public function authorized_users_can_delete_contacts()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);

        $contact = factory(Contact::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id
        ]);

        $this->deleteJson(route('contacts.destroy', $contact))
            ->assertStatus(204);

        $this->assertNotNull($contact->fresh()->deleted_at);
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_contacts()
    {
        $user = factory(User::class)->states('email-not-confirmed')->create();
        $this->signIn($user);

        $contact = factory(Contact::class)->make();

        $this->post(route('contacts.store'), $contact->toArray())
            ->assertRedirect(route('profile.index'))
            ->assertSessionHas('flash');
    }

    /** @test */
    public function user_contact_validation_fails_if_name_is_shorter_than_3_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'Jo',
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_name_is_longer_than_45_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => str_repeat('a', 50),
            'address_line1' => 'Neibolt St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line1_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line1_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 123,
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line1_is_shorter_than_3_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'St',
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line1_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => str_repeat('a', 256),
            'address_line2' => 'Old House',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line1');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line2_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street name',
            'address_line2' => 123,
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line2_is_shorter_than_3_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street name',
            'address_line2' => 'Ol',
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_address_line2_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street name',
            'address_line2' => str_repeat('a', 256),
            'zip' => '43210',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('address_line2');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_zip_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_zip_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => 2950,
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_zip_is_shorter_than_4_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '295',
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_zip_is_longer_than_16_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => str_repeat('1', 17),
            'city' => 'Derry',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('zip');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_city_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_city_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 123,
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_city_is_shorter_than_2_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'S',
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_city_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => str_repeat('a', 256),
            'phone_number' => '0123456789',
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('city');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_phone_number_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => 123456789,
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('phone_number');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_phone_number_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => str_repeat('1', 256),
            'fax' => '0123456789',
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('phone_number');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_fax_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '123456789',
            'fax' => 123456789,
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('fax');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_fax_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '123456789',
            'fax' => str_repeat('1', 256),
            'email' => 'derry@example.com'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('fax');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_email_is_missing()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '123456789',
            'fax' => '123456789',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_email_is_not_a_valid_email_format()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '123456789',
            'fax' => '123456789',
            'email' => 'something-invalid'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function user_contact_validation_fails_if_email_is_longer_than_45_characters()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '123456789',
            'fax' => '123456789',
            'email' => str_repeat('a', 46)
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function admin_contact_validation_fails_if_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->create();
        $this->signIn($admin);

        $response = $this->postJson(route('contacts.store'), [
            'name' => 'At Home',
            'address_line1' => 'Street Name2e',
            'address_line2' => 'Old House',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '123456789',
            'fax' => '123456789',
            'email' => str_repeat('a', 46),
            'company_id' => 42
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('company_id');
        $this->assertCount(0, Contact::all());
    }
}
