<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        return $this->company = factory('App\Company')->create();
    }

    /**
     * Company index view is available
     *
     * @test
     */
    function company_index_view_is_available()
    {
        $response = $this->get('/companies');
        $response->assertViewIs('companies.index');
    }
    
    /**
     * Company create view is available
     * 
     * @test
     */
    function company_create_view_is_available()
    {
        $response = $this->get('/companies/create');
        $response->assertViewIs('companies.create');
    }

    /**
     * Company show view is available
     *
     * @test
     */
    function company_show_view_is_available()
    {
        $response = $this->get('/companies/' . $this->company->name);
        $response->assertViewIs('companies.show');
    }

    /**
     * Company edit view is available
     *
     * @test
     */
    function company_edit_view_is_available()
    {
        $response = $this->get('/companies/' . $this->company->name . '/edit');
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
