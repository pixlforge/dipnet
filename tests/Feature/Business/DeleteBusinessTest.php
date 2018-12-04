<?php

namespace Tests\Feature\Business;

use App\User;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Company;

class DeleteBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_soft_delete_existing_businesses()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $business = factory(Business::class)->create();
        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('admin.businesses.destroy', $business));
        $response->assertSuccessful();
        $this->assertNotNull($business->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_soft_delete_existing_businesses()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create();
        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('admin.businesses.destroy', $business));
        $response->assertForbidden();
        $this->assertNull($business->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_soft_delete_existing_businesses()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $business = factory(Business::class)->create();
        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('admin.businesses.destroy', $business));
        $response->assertRedirect(route('login'));
        $this->assertNull($business->fresh()->deleted_at);
    }
    
    /** @test */
    public function users_associated_with_a_company_can_delete_their_own_businesses()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->create(['company_id' => $company->id]);
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('businesses.destroy', $business));

        $response->assertSuccessful();
        $this->assertNotNull($business->fresh()->deleted_at);
    }

    /** @test */
    public function solo_users_with_a_company_can_delete_their_own_businesses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('solo')->create();
        $business = factory(Business::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertNull($business->deleted_at);

        $response = $this->deleteJson(route('businesses.destroy', $business));

        $response->assertSuccessful();
        $this->assertNotNull($business->fresh()->deleted_at);
    }

    /** @test */
    public function solo_users_cannot_delete_businesses_they_do_not_own()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $business = factory(Business::class)->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertNull($business->deleted_at);
        
        $response = $this->deleteJson(route('businesses.destroy', $business));
        
        $response->assertForbidden();
        $this->assertNull($business->deleted_at);
    }

    /** @test */
    public function users_associated_with_a_company_cannot_delete_businesses_their_company_does_not_own()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $user = factory(User::class)->create(['company_id' => $company->id]);

        $business = factory(Business::class)->create(['company_id' => $otherCompany->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertNull($business->deleted_at);
        
        $response = $this->deleteJson(route('businesses.destroy', $business));
        
        $response->assertForbidden();
        $this->assertNull($business->deleted_at);
    }
}
