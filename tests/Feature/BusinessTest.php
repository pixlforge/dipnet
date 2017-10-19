<?php

namespace Tests\Feature;

use App\Business;
use App\Company;
use App\Contact;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_create_new_businesses()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create();

        $this->postJson(route('businesses.store'), [
            'name' => 'Braderie',
            'reference' => '85erfgbn',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
            'contact_id' => $contact->id
        ])->assertStatus(200);

        $this->assertDatabaseHas('businesses', [
            'name' => 'Braderie',
            'reference' => '85erfgbn',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
            'contact_id' => $contact->id
        ]);
    }

    /** @test */
    function an_admin_can_update_a_business()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $business = factory(Business::class)->create();

        $this->putJson(route('businesses.update', $business), [
            'name' => 'Braderie',
            'reference' => '85erfgbn',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $business->company_id,
            'contact_id' => $business->contact_id
        ])->assertStatus(200);

        $this->assertDatabaseHas('businesses', [
            'name' => 'Braderie',
            'reference' => '85erfgbn',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $business->company_id,
            'contact_id' => $business->contact_id
        ]);
    }

    /** @test */
    function an_admin_can_delete_a_business()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $business = factory(Business::class)->create();

        $this->deleteJson(route('businesses.destroy', $business))->assertStatus(204);
        $this->assertNotNull($business->fresh()->deleted_at);
    }
}