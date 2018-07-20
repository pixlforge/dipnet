<?php

namespace Tests\Feature\Company;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_new_companies()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertOk();
        $this->assertCount(1, Company::all());
    }

    /** @test */
    public function users_cannot_create_new_companies()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertForbidden();
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function guests_cannot_create_new_companies()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertRedirect(route('login'));
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => '',
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 123,
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => str_repeat('a', 2),
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => str_repeat('a', 46),
            'status' => 'permanent',
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_status_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => '',
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('status');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_status_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 123,
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('status');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_status_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 'something-else',
            'description' => 'Some basic company description',
        ]);
        $response->assertJsonValidationErrors('status');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 'permanent',
            'description' => 123,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function company_creation_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Company::all());

        $response = $this->postJson(route('admin.companies.store'), [
            'name' => 'Apple',
            'status' => 'permanent',
            'description' => str_repeat('a', 256),
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Company::all());
    }
}
