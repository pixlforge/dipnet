<?php

namespace Tests\Feature\Business;

use Dipnet\Business;
use Dipnet\Company;
use Dipnet\Contact;
use Dipnet\User;
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
            'contact_id' => $business->contact_id,
            'folder_color' => 'blue'
        ])->assertStatus(200);

        $this->assertDatabaseHas('businesses', [
            'name' => 'Braderie',
            'reference' => '85erfgbn',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $business->company_id,
            'contact_id' => $business->contact_id,
            'folder_color' => 'blue'
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

    /** @test */
    function a_user_can_create_a_new_business()
    {
        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->signIn($user);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create();

        $this->postJson(route('businesses.store'), [
            'name' => 'Awesome business',
            'description' => 'John Doe\'s first business',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'blue'
        ]);

        $this->assertCount(1, Business::all());

        $this->assertDatabaseHas('businesses', [
            'name' => 'Awesome business',
            'description' => 'John Doe\'s first business',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'blue'
        ]);
    }

    /** @test */
    function users_can_reach_the_business_show_page()
    {
        $company = factory(Company::class)->create([
            'name' => "John Doe's company"
        ]);

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company_id' => $company->id
        ]);
        $this->signIn($user);

        $business = factory(Business::class)->create([
            'name' => "John Doe's business",
            'company_id' => $company->id
        ]);

        $this->get(route('businesses.show', $business))
            ->assertStatus(200);
    }

    /** @test */
//    function a_user_can_update_his_own_businesses()
//    {
//
//    }
}