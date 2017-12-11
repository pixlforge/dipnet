<?php

namespace Tests\Feature\Company;

use Dipnet\Company;
use Dipnet\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_all_companies()
    {
        $user = factory(User::class)->states('admin')->create([
            'username' => 'John Doe'
        ]);
        $this->signIn($user);

        $this->get(route('companies.index'))
            ->assertStatus(200)
            ->assertSee('John Doe');
    }

    /** @test */
    function an_admin_can_create_new_companies()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('companies.store'), [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsum dolor sit amet.'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsum dolor sit amet.'
        ]);
    }

    /** @test */
    function a_company_can_be_updated()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('companies.store'), [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ]);

        $company = Company::whereName('Pixlforge')->first();

        $this->putJson(route('companies.update', $company), [
            'name' => 'Bebold',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ])->assertStatus(200);

        $this->assertDatabaseMissing('companies', [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ]);

        $this->assertDatabaseHas('companies', [
            'name' => 'Bebold',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ]);
    }

    /** @test */
    function a_company_can_be_deleted()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('companies.store'), [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ])->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'name' => 'Pixlforge',
            'status' => 'permanent',
            'description' => 'Lorem ipsium dolor sit amet.'
        ]);

        $company = Company::whereName('Pixlforge')->first();

        $this->deleteJson(route('companies.destroy', $company))->assertStatus(204);
        $this->assertNotNull($company->fresh()->deleted_at);
    }
}