<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Company views are available
     *
     * @test
     */
    function company_views_are_available()
    {
        $response = $this->get('/companies');
        $response->assertViewIs('companies.index');

        $response = $this->get('/companies/create');
        $response->assertViewIs('companies.create');

        $response = $this->get('/companies/company-id');
        $response->assertViewIs('companies.show');

        $response = $this->get('/companies/company-id/edit');
        $response->assertViewIs('companies.edit');
    }

    /**
     * A company can be inserted into the database
     *
     * @test
     */
    function a_company_can_be_inserted_into_the_database()
    {
       $company = factory('App\Company')->create();
       $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }
}
