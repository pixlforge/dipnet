<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a Company for all tests to use.
     *
     * @return mixed
     */
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
        $this->signIn(null, 'administrateur');

        $response = $this->get('/companies');

        $response->assertViewIs('companies.index');
    }

    /**
     * Authorized users can create companies
     *
     * @test
     */
    function authorized_users_can_create_companies()
    {
        $this->signIn(null, 'administrateur');

        $company = factory('App\Company')->create();

        $this->post("/companies", $company->toArray())
            ->assertRedirect('/companies');
    }

    /**
     * Authorized users can update companies
     *
     * @test
     */
    function authorized_users_can_update_companies()
    {
        $this->signIn(null, 'administrateur');

        $company = factory('App\Company')->create();

        $this->post("/companies", $company->toArray())
            ->assertRedirect('/companies');

        $company->city = 'Courgenay';

        $this->put("/companies/{$company->id}", $company->toArray())
            ->assertRedirect('/companies');
    }

    /**
     * Authorized users can delete companies
     *
     * @test
     */
    function authorized_users_can_delete_companies()
    {
        $this->signIn(null, 'administrateur');

        $company = factory('App\Company')->create();

        $this->assertDatabaseHas('companies', ['id' => $company->id]);

        $this->delete("/companies/{$company->id}")
            ->assertRedirect('/companies');
    }

    /**
     * Authorized users can restore companies
     *
     * @test
     */
    function authorized_users_can_restore_companies()
    {
        $this->signIn(null, 'administrateur');

        $company = factory('App\Company')->create();

        $this->assertDatabaseHas('companies', ['id' => $company->id]);

        $this->delete("/companies/{$company->id}")
            ->assertRedirect('/companies');

        $this->put("/companies/{$company->id}/restore", [$company])
            ->assertRedirect('/companies');
    }
}
