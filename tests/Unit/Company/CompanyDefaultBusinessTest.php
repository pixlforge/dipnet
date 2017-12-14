<?php

namespace Tests\Unit\Company;

use Dipnet\Business;
use Dipnet\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyDefaultBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_company_has_a_default_business()
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
}
