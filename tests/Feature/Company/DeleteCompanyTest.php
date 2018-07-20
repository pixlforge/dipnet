<?php

namespace Tests\Feature\Company;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_delete_existing_companies()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create();
        $this->assertNull($company->deleted_at);

        $response = $this->deleteJson(route('admin.companies.destroy', $company));
        $response->assertSuccessful();
        $this->assertNotNull($company->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_delete_existing_companies()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $company = factory(Company::class)->create();
        $this->assertNull($company->deleted_at);

        $response = $this->deleteJson(route('admin.companies.destroy', $company));
        $response->assertForbidden();
        $this->assertNull($company->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_existing_companies()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $company = factory(Company::class)->create();
        $this->assertNull($company->deleted_at);

        $response = $this->deleteJson(route('admin.companies.destroy', $company));
        $response->assertRedirect(route('login'));
        $this->assertNull($company->fresh()->deleted_at);
    }
}
