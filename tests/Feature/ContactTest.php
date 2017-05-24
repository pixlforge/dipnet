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
