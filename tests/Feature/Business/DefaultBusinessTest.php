<?php

namespace Tests\Feature\Business;

use App\User;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contact;

class DefaultBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_without_a_default_business_are_redirected_when_trying_to_access_the_order_creation_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertNull($company->business_id);

        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('companies.default.business.edit'));
    }

    /** @test */
    public function users_redirected_can_access_the_default_business_edit_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('companies.default.business.edit'));
        $response->assertOk();
        $response->assertViewIs('companies.default.business.edit');
    }

    /** @test */
    public function guests_cannot_access_the_default_business_edit_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('companies.default.business.edit'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function users_can_select_a_default_business_for_their_company()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertFalse($company->hasDefaultBusiness());

        $response = $this->patchJson(route('companies.default.business.update', $company), [
            'business_id' => $business->id
        ]);
        $response->assertOk();
        $this->assertTrue($company->fresh()->hasDefaultBusiness());
    }

    /** @test */
    public function select_a_default_business_validation_fails_if_business_is_missing()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertFalse($company->hasDefaultBusiness());

        $response = $this->patchJson(route('companies.default.business.update', $company), [
            'business_id' => ''
        ]);
        $response->assertJsonValidationErrors('business_id');
        $this->assertFalse($company->fresh()->hasDefaultBusiness());
    }

    /** @test */
    public function select_a_default_business_validation_fails_if_business_does_not_exist()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertFalse($company->hasDefaultBusiness());

        $response = $this->patchJson(route('companies.default.business.update', $company), [
            'business_id' => 999,
        ]);
        $response->assertJsonValidationErrors('business_id');
        $this->assertFalse($company->fresh()->hasDefaultBusiness());
    }

    /** @test */
    public function users_cannot_select_default_businesses_for_companies_they_do_not_own()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertFalse($company->hasDefaultBusiness());
        $this->assertFalse($otherCompany->hasDefaultBusiness());

        $response = $this->patchJson(route('companies.default.business.update', $otherCompany), [
            'business_id' => $business->id,
        ]);
        $response->assertForbidden();
        $this->assertFalse($otherCompany->fresh()->hasDefaultBusiness());
    }

    /** @test */
    public function users_cannot_select_default_businesses_for_businesses_they_do_not_own()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $otherBusiness = factory(Business::class)->create(['company_id' => $otherCompany->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertFalse($company->hasDefaultBusiness());
        $this->assertFalse($otherCompany->hasDefaultBusiness());

        $response = $this->patchJson(route('companies.default.business.update', $company), [
            'business_id' => $otherBusiness->id,
        ]);
        $response->assertForbidden();
        $this->assertFalse($otherCompany->fresh()->hasDefaultBusiness());
    }

    /** @test */
    public function users_can_create_a_new_business_and_define_it_as_their_companys_default_business()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());
        $this->assertFalse($company->hasDefaultBusiness());
        
        $response = $this->postJson(route('companies.default.business.store', $company), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet',
            'contact_id' => $contact->id,
        ]);

        $response->assertOk();
        $this->assertCount(1, Business::all());
        
        $company = $company->fresh();
        $business = Business::first();
        
        $this->assertTrue($company->hasDefaultBusiness());
        $this->assertEquals($business->id, $company->business_id);
    }

    /** @test */
    public function guests_cannot_create_a_new_business_and_define_it_as_a_companys_default_business()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->assertGuest();

        $this->assertCount(0, Business::all());
        $this->assertFalse($company->hasDefaultBusiness());
        
        $response = $this->postJson(route('companies.default.business.store', $company), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet',
            'contact_id' => $contact->id,
        ]);

        $response->assertStatus(401);
        $this->assertCount(0, Business::all());
        
        $company = $company->fresh();
        $business = Business::first();

        $this->assertFalse($company->hasDefaultBusiness());
        $this->assertNull($business);
    }

    /** @test */
    public function users_cannot_create_new_businesses_and_define_them_as_default_for_other_companies()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());
        $this->assertFalse($company->hasDefaultBusiness());
        
        $response = $this->postJson(route('companies.default.business.store', $otherCompany), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet',
            'contact_id' => $contact->id,
        ]);

        $response->assertForbidden();
        $this->assertCount(0, Business::all());
        
        $company = $company->fresh();
        $business = Business::first();
        
        $this->assertFalse($company->hasDefaultBusiness());
        $this->assertNull($business);
    }
}
