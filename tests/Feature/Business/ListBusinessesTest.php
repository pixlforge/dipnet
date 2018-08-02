<?php

namespace Tests\Feature\Business;

use App\User;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListBusinessesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_admin_businesses_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.businesses.index'));
        $response->assertOk();
        $response->assertViewIs('admin.businesses.index');
        $response->assertSee('Liste de toutes les affaires');
    }

    /** @test */
    public function users_cannot_access_the_admin_businesses_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.businesses.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_admin_businesses_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.businesses.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function users_can_access_the_user_businesses_index_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('businesses.index'));
        $response->assertOk();
        $response->assertViewIs('businesses.index');
    }

    /** @test */
    public function guests_cannot_access_the_user_businesses_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('businesses.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_businesses_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Business::class, 25)->create();

        $businesses = $this->getJson(route('api.businesses.index'));
        $this->assertCount(25, $businesses->getData()->data);
    }

    /** @test */
    public function users_associated_with_a_company_can_fetch_their_own_businesses_via_the_api()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Business::class, 5)->create(['company_id' => $company->id]);
        factory(Business::class, 5)->create();

        $businesses = $this->getJson(route('api.businesses.index'));
        $this->assertCount(5, $businesses->getData()->data);
    }

    /** @test */
    public function solo_users_can_fetch_their_own_businesses_via_the_api()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Business::class, 5)->create(['user_id' => $user->id]);
        factory(Business::class, 5)->create();

        $businesses = $this->getJson(route('api.businesses.index'));
        $this->assertCount(5, $businesses->getData()->data);
    }

    /** @test */
    public function guests_cannot_fetch_businesses_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        factory(Business::class, 5)->create();

        $response = $this->getJson(route('api.businesses.index'));
        $response->assertStatus(401);
    }

    /** @test */
    public function admins_can_fetch_businesses_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Business::class)->create(['name' => 'BusinessE']);
        factory(Business::class)->create(['name' => 'BusinessD']);
        factory(Business::class)->create(['name' => 'BusinessA']);
        factory(Business::class)->create(['name' => 'BusinessC']);
        factory(Business::class)->create(['name' => 'BusinessB']);

        $response = $this->getJson(route('api.businesses.index', 'name'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'BusinessA',
            'BusinessB',
            'BusinessC',
            'BusinessD',
            'BusinessE',
        ]);
    }

    /** @test */
    public function admins_can_fetch_businesses_via_the_api_sorted_by_reference()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Business::class)->create(['reference' => 'REFERENB']);
        factory(Business::class)->create(['reference' => 'REFERENE']);
        factory(Business::class)->create(['reference' => 'REFERENC']);
        factory(Business::class)->create(['reference' => 'REFEREND']);
        factory(Business::class)->create(['reference' => 'REFERENA']);

        $response = $this->getJson(route('api.businesses.index', 'reference'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'REFERENA',
            'REFERENB',
            'REFERENC',
            'REFEREND',
            'REFERENE',
        ]);
    }

    /** @test */
    public function admins_can_fetch_businesses_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Business::class)->create([
            'name' => 'BusinessE',
            'created_at' => now()->addDay(),
        ]);
        factory(Business::class)->create([
            'name' => 'BusinessD',
            'created_at' => now()->subDay(),
        ]);
        factory(Business::class)->create([
            'name' => 'BusinessA',
            'created_at' => now()->addWeek(),
        ]);
        factory(Business::class)->create([
            'name' => 'BusinessC',
            'created_at' => now()->subWeek(),
        ]);
        factory(Business::class)->create([
            'name' => 'BusinessB',
            'created_at' => now(),
        ]);

        $response = $this->getJson(route('api.businesses.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'BusinessA',
            'BusinessE',
            'BusinessB',
            'BusinessD',
            'BusinessC',
        ]);
    }
}
