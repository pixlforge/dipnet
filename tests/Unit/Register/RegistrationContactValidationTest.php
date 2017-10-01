<?php

namespace Tests\Unit\Register;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationContactValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();

        $user = factory('App\User')->states('not-confirmed')->create();
        $this->signIn($user);
    }

    /** @test */
    function validation_fails_if_name_is_missing()
    {
        $this->json('POST', route('register.contact.store'), [
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(422);
    }

    /** @test */
    function validation_fails_if_address_is_missing()
    {
        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(422);
    }

    /** @test */
    function validation_fails_if_zip_is_missing()
    {
        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'city' => 'Castle Black',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(422);
    }

    /** @test */
    function validation_fails_if_city_is_missing()
    {
        $this->json('POST', route('register.contact.store'), [
            'name' => 'Castle Black',
            'address_line1' => 'Castle Black, The Wall',
            'address_line2' => 'Lord Commander\'s Headquarters',
            'zip' => '10100',
            'phone_number' => '012 34 56 78',
            'fax' => '012 34 56 789',
        ])->assertStatus(422);
    }
}
