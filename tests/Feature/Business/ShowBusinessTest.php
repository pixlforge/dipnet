<?php

namespace Tests\Feature\Business;

use App\User;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowBusinessTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function users_can_access_their_own_businesses_show_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('businesses.show', $business));
        $response->assertOk();
        $response->assertViewIs('businesses.show');
    }

    /** @test */
    public function users_cannot_access_other_businesses_show_page()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $otherCompany->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('businesses.show', $business));
        $response->assertForbidden();
    }
}
