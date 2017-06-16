<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

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
        $this->signIn();

        $response = $this->get('/contacts');

        $response->assertViewIs('contacts.index');
    }

    /**
     * Contact create view is available
     *
     * @test
     */
    function contact_create_view_is_available()
    {
        $this->signIn();

        $response = $this->get('/contacts/create');

        $response->assertViewIs('contacts.create');
    }
    
    /**
     * Contact show view is available and requires a contact
     * 
     * @test
     */
    function contact_show_view_is_available_and_requires_a_contact()
    {
        $this->signIn();

        $response = $this->get('/contacts/' . $this->contact->name);

        $response->assertViewIs('contacts.show');
    }
    
    /**
     * Contact edit view is available and requires a contact
     * 
     * @test
     */
    function contact_edit_view_is_available_and_requires_a_contact()
    {
        $this->signIn();

        $response = $this->get('/contacts/' . $this->contact->id . '/edit');

        $response->assertViewIs('contacts.edit');
    }

    /**
     * Authorized users can create contacts
     *
     * @test
     */
    function authorized_users_can_create_contacts()
    {
        $this->signIn();

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
        $this->signIn();

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
        $this->signIn();

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
        $this->signIn();

        $contact = factory('App\Contact')->create();

        $this->assertDatabaseHas('contacts', ['id' => $contact->id]);

        $this->delete("/contacts/{$contact->id}")
            ->assertRedirect('/contacts');

        $this->put("/contacts/{$contact->id}/restore", [$contact])
            ->assertRedirect('/contacts');
    }

}









