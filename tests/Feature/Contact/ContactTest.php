<?php

namespace Tests\Feature\Contact;

use Dipnet\User;
use Dipnet\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function contact_index_view_is_available()
    {
        $this->signIn();

        $response = $this->get(route('contacts.index'));

        $response->assertViewIs('contacts.index');
    }

    /** @test */
    function authorized_users_can_create_contacts()
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
    function authorized_users_can_update_contacts()
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
            'email' => 'celien@pixlforge.ch',
            'company_id' => null
        ]);
    }

    /** @test */
    function authorized_users_can_delete_contacts()
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
    function new_users_must_first_confirm_their_email_address_before_creating_contacts()
    {
        $user = factory(User::class)->states('email-not-confirmed')->create();
        $this->signIn($user);

        $contact = factory(Contact::class)->make();

        $this->post(route('contacts.store'), $contact->toArray())
            ->assertRedirect(route('profile.index'))
            ->assertSessionHas('flash');
    }
}









