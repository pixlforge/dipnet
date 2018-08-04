<?php

namespace Tests\Feature\Contact;

use App\User;
use App\Contact;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_admin_contacts_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.contacts.index'));
        $response->assertOk();
        $response->assertViewIs('admin.contacts.index');
        $response->assertSee('Liste de tous les contacts');
    }

    /** @test */
    public function users_cannot_access_the_admin_contacts_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.contacts.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_admin_contacts_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.contacts.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function users_can_access_the_user_contacts_index_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('contacts.index'));
        $response->assertOk();
        $response->assertViewIs('contacts.index');
        $response->assertSee('Liste de tous vos contacts');
    }

    /** @test */
    public function users_with_pending_email_confirmation_cannot_access_the_user_contacts_index_page()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user', 'email-not-confirmed')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('contacts.index'));
        $response->assertRedirect(route('profile.index'));
        $response->assertSessionHas(['flash' => "Vous devez d'abord confirmer votre adresse e-mail."]);
    }

    /** @test */
    public function guests_cannot_access_the_user_contacts_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('contacts.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function users_associated_with_a_company_can_only_see_their_companys_contacts()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class, 2)->create(['company_id' => $company->id]);
        factory(Contact::class, 3)->create(['company_id' => $otherCompany->id]);
        
        $this->assertCount(5, Contact::all());

        $response = $this->get(route('api.contacts.index'));
        $response->assertOk();
        $this->assertCount(2, $response->getData()->data);
    }

    /** @test */
    public function solo_users_can_only_see_their_own_contacts()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $otherUser = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class, 2)->create(['user_id' => $user->id]);
        factory(Contact::class, 3)->create(['user_id' => $otherUser->id]);
        
        $this->assertCount(5, Contact::all());

        $response = $this->get(route('api.contacts.index'));
        $response->assertOk();
        $this->assertCount(2, $response->getData()->data);
    }

    /** @test */
    public function admins_can_fetch_contacts_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Contact::class, 25)->create();

        $contacts = $this->getJson(route('api.contacts.index'));
        $this->assertCount(25, $contacts->getData()->data);
    }

    /** @test */
    public function users_associated_with_a_company_can_only_fetch_their_own_company_contacts_via_the_api()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class, 2)->create(['company_id' => $company->id]);
        factory(Contact::class, 3)->create();

        $this->assertCount(5, Contact::all());
        $contacts = $this->getJson(route('api.contacts.index'));
        $this->assertCount(2, $contacts->getData()->data);
    }

    /** @test */
    public function solo_users_can_only_fetch_their_own_contacts_via_the_api()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class, 2)->create(['user_id' => $user->id]);
        factory(Contact::class, 3)->create();

        $this->assertCount(5, Contact::all());
        $contacts = $this->getJson(route('api.contacts.index'));
        $this->assertCount(2, $contacts->getData()->data);
    }

    /** @test */
    public function guests_cannot_fetch_contacts_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->getJson(route('api.contacts.index'));
        $response->assertStatus(401);
    }

    /** @test */
    public function admins_can_fetch_contacts_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Contact::class)->create(['name' => "Bill's"]);
        factory(Contact::class)->create(['name' => "Zoey's"]);
        factory(Contact::class)->create(['name' => "Andy's"]);
        factory(Contact::class)->create(['name' => "Yann's"]);
        factory(Contact::class)->create(['name' => "Clara's"]);

        $response = $this->getJson(route('api.contacts.index', 'name'));
        $response->assertOk();
        $response->assertSeeInOrder([
            "Andy's",
            "Bill's",
            "Clara's",
            "Yann's",
            "Zoey's",
        ]);
    }

    /** @test */
    public function users_associated_with_a_company_can_fetch_contacts_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class)->create([
            'name' => "Bill's",
            'company_id' => $company->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Zoey's",
            'company_id' => $company->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Andy's",
            'company_id' => $company->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Yann's",
            'company_id' => $company->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Clara's",
            'company_id' => $company->id,
        ]);

        $response = $this->getJson(route('api.contacts.index', 'name'));
        $response->assertOk();
        $response->assertSeeInOrder([
            "Andy's",
            "Bill's",
            "Clara's",
            "Yann's",
            "Zoey's",
        ]);
    }

    /** @test */
    public function solo_users_can_fetch_contacts_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class)->create([
            'name' => "Bill's",
            'user_id' => $user->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Zoey's",
            'user_id' => $user->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Andy's",
            'user_id' => $user->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Yann's",
            'user_id' => $user->id,
        ]);
        factory(Contact::class)->create([
            'name' => "Clara's",
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(route('api.contacts.index', 'name'));
        $response->assertOk();
        $response->assertSeeInOrder([
            "Andy's",
            "Bill's",
            "Clara's",
            "Yann's",
            "Zoey's",
        ]);
    }

    /** @test */
    public function admins_can_fetch_contacts_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Contact::class)->create([
            'name' => "Bill's",
            'created_at' => now()->subMonth(),
        ]);
        factory(Contact::class)->create([
            'name' => "Zoey's",
            'created_at' => now()->addWeek(),
        ]);
        factory(Contact::class)->create([
            'name' => "Andy's",
            'created_at' => now(),
        ]);
        factory(Contact::class)->create([
            'name' => "Yann's",
            'created_at' => now()->subDay(),
        ]);
        factory(Contact::class)->create([
            'name' => "Clara's",
            'created_at' => now()->addHour(),
        ]);

        $response = $this->getJson(route('api.contacts.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            "Zoey's",
            "Clara's",
            "Andy's",
            "Yann's",
            "Bill's",
        ]);
    }

    /** @test */
    public function users_associated_with_a_company_can_fetch_contacts_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class)->create([
            'name' => "Bill's",
            'company_id' => $company->id,
            'created_at' => now()->subMonth(),
        ]);
        factory(Contact::class)->create([
            'name' => "Zoey's",
            'company_id' => $company->id,
            'created_at' => now()->addWeek(),
        ]);
        factory(Contact::class)->create([
            'name' => "Andy's",
            'company_id' => $company->id,
            'created_at' => now(),
        ]);
        factory(Contact::class)->create([
            'name' => "Yann's",
            'company_id' => $company->id,
            'created_at' => now()->subDay(),
        ]);
        factory(Contact::class)->create([
            'name' => "Clara's",
            'company_id' => $company->id,
            'created_at' => now()->addHour(),
        ]);

        $response = $this->getJson(route('api.contacts.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            "Zoey's",
            "Clara's",
            "Andy's",
            "Yann's",
            "Bill's",
        ]);
    }

    /** @test */
    public function solo_users_can_fetch_contacts_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Contact::class)->create([
            'name' => "Bill's",
            'user_id' => $user->id,
            'created_at' => now()->subMonth(),
        ]);
        factory(Contact::class)->create([
            'name' => "Zoey's",
            'user_id' => $user->id,
            'created_at' => now()->addWeek(),
        ]);
        factory(Contact::class)->create([
            'name' => "Andy's",
            'user_id' => $user->id,
            'created_at' => now(),
        ]);
        factory(Contact::class)->create([
            'name' => "Yann's",
            'user_id' => $user->id,
            'created_at' => now()->subDay(),
        ]);
        factory(Contact::class)->create([
            'name' => "Clara's",
            'user_id' => $user->id,
            'created_at' => now()->addHour(),
        ]);

        $response = $this->getJson(route('api.contacts.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            "Zoey's",
            "Clara's",
            "Andy's",
            "Yann's",
            "Bill's",
        ]);
    }
}
