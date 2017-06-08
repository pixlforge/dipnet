<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Contact views are available
     *
     * @test
     */
    function contact_views_are_available()
    {
        $response = $this->get('/contacts');
        $response->assertViewIs('contacts.index');

        $response = $this->get('/contacts/create');
        $response->assertViewIs('contacts.create');

        $response = $this->get('/contacts/contact-id');
        $response->assertViewIs('contacts.show');

        $response = $this->get('/contacts/contact-id/edit');
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
