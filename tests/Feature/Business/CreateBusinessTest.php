<?php

namespace Tests\Feature\Business;

use App\User;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_new_businesses_and_associate_them_with_a_company()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertOk();
        $this->assertCount(1, Business::all());
    }

    /** @test */
    public function admins_can_create_new_businesses_and_associate_them_with_a_user()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $user = factory(User::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'user_id' => $user->id,
        ]);
        $response->assertOk();
        $this->assertCount(1, Business::all());
    }

    /** @test */
    public function users_cannot_create_new_businesses()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertForbidden();
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function guests_cannot_create_new_businesses()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertRedirect(route('login'));
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => '',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 123,
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => str_repeat('a', 2),
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => str_repeat('a', 46),
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 123,
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => str_repeat('a', 46),
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_user_is_missing_when_company_is_also_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
        ]);
        $response->assertJsonValidationErrors('user_id');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_user_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'user_id' => 999,
        ]);
        $response->assertJsonValidationErrors('user_id');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_company_is_missing_when_user_is_also_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
        ]);
        $response->assertJsonValidationErrors('company_id');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => 999,
        ]);
        $response->assertJsonValidationErrors('company_id');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_contact_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => 999,
        ]);
        $response->assertJsonValidationErrors('contact_id');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function business_creation_validation_fails_if_folder_color_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'folder_color' => 'something-wrong',
        ]);
        $response->assertJsonValidationErrors('folder_color');
        $this->assertCount(0, Business::all());
    }
}
