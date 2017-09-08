<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a Contact for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();

        return $this->contact = factory('App\Contact')->create();
    }

    /**
     * Contact index view is available
     *
     * @test
     */
    function contact_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/contacts');

        $response->assertViewIs('contacts.index');
    }

    /**
     * Authorized users can create contacts
     *
     * @test
     */
    function authorized_users_can_create_contacts()
    {
        $this->signIn(null, 'administrateur');

        $contact = factory('App\Contact')->create();

        $this->post("/contacts", $contact->toArray())
            ->assertRedirect('/contacts');
    }

    /**
     * Authorized users can update contacts
     *
     * @test
     */
    function authorized_users_can_update_contacts()
    {
        $this->signIn(null, 'administrateur');

        $contact = factory('App\Contact')->create();

        $this->post("/contacts", $contact->toArray())
            ->assertRedirect('/contacts');

        $contact->city = 'Courgenay';

        $this->put("/contacts/{$contact->id}", $contact->toArray())
            ->assertRedirect('/contacts');
    }

    /**
     * Authorized users can delete contacts
     *
     * @test
     */
    function authorized_users_can_delete_contacts()
    {
        $this->signIn(null, 'administrateur');

        $contact = factory('App\Contact')->create();

        $this->assertDatabaseHas('contacts', ['id' => $contact->id]);

        $this->delete("/contacts/{$contact->id}")
            ->assertRedirect('/contacts');
    }

    /**
     * Authorized users can restore contacts
     *
     * @test
     */
    function authorized_users_can_restore_contacts()
    {
        $this->signIn(null, 'administrateur');

        $contact = factory('App\Contact')->create();

        $this->assertDatabaseHas('contacts', ['id' => $contact->id]);

        $this->delete("/contacts/{$contact->id}")
            ->assertRedirect('/contacts');

        $this->put("/contacts/{$contact->id}/restore", [$contact])
            ->assertRedirect('/contacts');
    }

    /**
     * Authenticated users must first confirm their email address before creating contacts
     *
     * @test
     */
    function authenticated_users_must_first_confirm_their_email_address_before_creating_contacts()
    {
        $this->signIn(factory('App\User')
            ->states('not-confirmed')
            ->create());

        $contact = factory('App\Contact')->make();
        $this->post(route('contacts'), $contact->toArray())
            ->assertRedirect(route('profile'))
            ->assertSessionHas('flash');

    }
}









