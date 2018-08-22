<?php

namespace Tests\Feature\Contact;

use App\User;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Company;

class ShowContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_a_contacts_show_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();

        $response = $this->get(route('contacts.show', $contact));

        $response->assertOk();
        $response->assertViewIs('contacts.show');
    }

    /** @test */
    public function users_associated_with_a_company_can_access_their_own_contacts_show_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create(['company_id' => $company->id]);

        $response = $this->get(route('contacts.show', $contact));

        $response->assertOk();
        $response->assertViewIs('contacts.show');
    }

    /** @test */
    public function solo_users_can_access_their_own_contacts_show_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create(['user_id' => $user->id]);

        $response = $this->get(route('contacts.show', $contact));

        $response->assertOk();
        $response->assertViewIs('contacts.show');
    }

    /** @test */
    public function users_cannot_access_others_contact_show_page()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $otherUser = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id' => $otherUser->id]);

        $response = $this->get(route('contacts.show', $contact));

        $response->assertForbidden();
    }
}
