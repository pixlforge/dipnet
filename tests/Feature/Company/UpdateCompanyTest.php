<?php

namespace Tests\Feature\Company;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_existing_companies()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertOk();

        $company = $company->fresh();
        $this->assertEquals('Multicop', $company->name);
        $this->assertEquals('permanent', $company->status);
        $this->assertEquals("There's really no end to this. You are only limited by your imagination.", $company->description);
    }

    /** @test */
    public function users_cannot_update_existing_companies()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertForbidden();

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function guests_cannot_update_existing_companies()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertRedirect(route('login'));

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => '',
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('name');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 123,
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('name');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => str_repeat('a', 2),
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('name');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => str_repeat('a', 46),
            'status' => 'permanent',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('name');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_status_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => '',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('status');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_status_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 123,
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('status');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_status_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'something-else',
            'description' => "There's really no end to this. You are only limited by your imagination.",
        ]);
        $response->assertJsonValidationErrors('status');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'permanent',
            'description' => 123,
        ]);
        $response->assertJsonValidationErrors('description');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);

        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'permanent',
            'description' => str_repeat('a', 256),
        ]);
        $response->assertJsonValidationErrors('description');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }

    /** @test */
    public function update_company_validation_fails_if_business_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create([
            'name' => 'Dip',
            'status' => 'temporaire',
            'description' => 'You can create anything that makes you happy.',
        ]);


        $response = $this->patchJson(route('admin.companies.update', $company), [
            'name' => 'Multicop',
            'status' => 'permanent',
            'description' => str_repeat('a', 256),
            'business_id' => 999,
        ]);
        $response->assertJsonValidationErrors('business_id');

        $company = $company->fresh();
        $this->assertEquals('Dip', $company->name);
        $this->assertEquals('temporaire', $company->status);
        $this->assertEquals('You can create anything that makes you happy.', $company->description);
    }
}
