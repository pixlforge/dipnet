<?php

namespace Tests\Feature\Company;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListCompaniesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_companies_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.companies.index'));
        $response->assertOk();
        $response->assertViewIs('admin.companies.index');
        $response->assertSee('Liste de toutes les sociétés');
    }

    /** @test */
    public function users_cannot_access_the_companies_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.companies.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_companies_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.companies.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_companies_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Company::class, 25)->create();

        $companies = $this->getJson(route('api.companies.index'));
        $this->assertCount(25, $companies->getData()->data);
    }

    /** @test */
    public function users_cannot_fetch_companies_via_the_api()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->getJson(route('api.companies.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_fetch_companies_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->getJson(route('api.companies.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_companies_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Company::class)->create(['name' => 'Boeing']);
        factory(Company::class)->create(['name' => 'Zend']);
        factory(Company::class)->create(['name' => 'Apple']);
        factory(Company::class)->create(['name' => 'Yahoo']);
        factory(Company::class)->create(['name' => 'Cisco']);

        $response = $this->getJson(route('api.companies.index', 'name'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Apple',
            'Boeing',
            'Cisco',
            'Yahoo',
            'Zend',
        ]);
    }

    /** @test */
    public function admins_can_fetch_companies_via_the_api_sorted_by_status()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Company::class)->create([
            'name' => 'Boeing',
            'status' => 'temporaire',
        ]);
        factory(Company::class)->create([
            'name' => 'Zend',
            'status' => 'permanent',
        ]);
        factory(Company::class)->create([
            'name' => 'Apple',
            'status' => 'temporaire',
        ]);
        factory(Company::class)->create([
            'name' => 'Yahoo',
            'status' => 'permanent',
        ]);
        factory(Company::class)->create([
            'name' => 'Cisco',
            'status' => 'temporaire',
        ]);

        $response = $this->getJson(route('api.companies.index', 'status'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Yahoo',
            'Zend',
            'Apple',
            'Boeing',
            'Cisco',
        ]);
    }

    /** @test */
    public function admins_can_fetch_companies_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Company::class)->create([
            'name' => 'Boeing',
            'created_at' => now()->addDay(),
        ]);
        factory(Company::class)->create([
            'name' => 'Zend',
            'created_at' => now()->addYear(),
        ]);
        factory(Company::class)->create([
            'name' => 'Apple',
            'created_at' => now(),
        ]);
        factory(Company::class)->create([
            'name' => 'Yahoo',
            'created_at' => now()->subWeek(),
        ]);
        factory(Company::class)->create([
            'name' => 'Cisco',
            'created_at' => now()->subMonth(),
        ]);

        $response = $this->getJson(route('api.companies.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Zend',
            'Boeing',
            'Apple',
            'Yahoo',
            'Cisco',
        ]);
    }
}
