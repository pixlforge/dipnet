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
        $response = $this->get('/contacts/' . $this->contact->name . '/edit');
        $response->assertViewIs('contacts.edit');
    }

    /**
     * A contact can be inserted into the database
     *
     * @test
     */
    function a_contact_can_be_inserted_into_the_database()
    {
        $contact = factory('App\Contact')->create();
        $this->assertDatabaseHas('contacts', ['name' => $contact->name]);
    }
}









