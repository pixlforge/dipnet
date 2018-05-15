<?php

namespace Tests\Feature\Company;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->admin = factory(User::class)->states('admin')->create();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    function update_validation_fails_if_no_default_business_is_provided_by_users()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $company = factory(Company::class)->create([
            'name' => 'John Doe\'s company'
        ]);

        $this->assertNull($company->business_id);

        $this->putJson(route('companies.update', $company), [
            'name' => 'Jane Doe\' company',
            'status' => $company->status
        ])->assertStatus(422);

        $this->assertEquals('John Doe\'s company', $company->fresh()->name);
    }

    /** @test */
    function update_validation_fails_if_business_provided_by_admins_does_not_exist()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->admin);

        $company = factory(Company::class)->create([
            'name' => 'John Doe\'s company'
        ]);

        $this->assertNull($company->business_id);

        $this->putJson(route('companies.update', $company), [
            'name' => 'Jane Doe\' company',
            'status' => $company->status,
            'business_id' => 48
        ])->assertStatus(422);

        $this->assertEquals('John Doe\'s company', $company->fresh()->name);
    }
}
