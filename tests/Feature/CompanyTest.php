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
