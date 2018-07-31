<?php

namespace Tests\Unit\Company;

use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_company_has_a_default_business()
    {
        $company = factory(Company::class)->create([
            'name' => 'John Doe\'s company',
            'business_id' => function () {
                return factory(Business::class)->create([
                    'name' => 'John Doe\'s business'
                ])->id;
            }
        ]);

        $this->assertNotNull($company->business_id);
    }

    /** @test */
    public function companies_have_a_slug_attribute()
    {
        $company = factory(Company::class)->create(['name' => 'Laravel']);
        $this->assertEquals('laravel', $company->slug);
    }
}
