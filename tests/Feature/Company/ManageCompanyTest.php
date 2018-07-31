<?php

namespace Tests\Feature\Company;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_can_visit_their_company_profile()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create(['name' => "John Doe's Company"]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('companies.show', $company));
        $response->assertOk();
        $response->assertViewIs('companies.show');
    }
}
