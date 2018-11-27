<?php

namespace Tests\Feature\Business;

use App\User;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contact;

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
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
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
        $contact = factory(Contact::class)->create(['user_id' => $user->id]);

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => 'Lorem ipsum dolor sit amet.',
            'user_id' => $user->id,
            'contact_id' => $contact->id
        ]);
        $response->assertOk();
        $this->assertCount(1, Business::all());
    }

    /** @test */
    public function users_cannot_create_new_businesses_in_the_admin_panel()
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
    public function guests_cannot_create_new_businesses_in_the_admin_panel()
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
    public function users_associated_with_a_company_can_create_businesses_for_their_company()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet',
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertOk();
        $this->assertCount(1, Business::all());
        $business = Business::first();
        $this->assertEquals($company->id, $business->company_id);
        $this->assertNull($business->user_id);
    }

    /** @test */
    public function solo_users_can_create_businesses_associated_with_themselves()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertTrue($user->isSolo());
        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet',
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertOk();
        $this->assertCount(1, Business::all());
        $business = Business::first();
        $this->assertEquals($user->id, $business->user_id);
        $this->assertNull($business->company_id);
    }

    /** @test */
    public function guests_cannot_create_new_businesses()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $contact = factory(Contact::class)->create();

        $this->assertCount(0, Business::all());
        
        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet',
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertStatus(401);
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function admin_business_creation_validation_fails_if_name_is_missing()
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
    public function admin_business_creation_validation_fails_if_name_is_not_a_string()
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
    public function admin_business_creation_validation_fails_if_name_is_too_short()
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
    public function admin_business_creation_validation_fails_if_name_is_too_long()
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
    public function admin_business_creation_validation_fails_if_description_is_not_a_string()
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
    public function admin_business_creation_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Business::all());

        $company = factory(Company::class)->create();

        $response = $this->postJson(route('admin.businesses.store'), [
            'name' => 'Fête Nationale',
            'description' => str_repeat('a', 256),
            'company_id' => $company->id,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function admin_business_creation_validation_fails_if_user_is_missing_when_company_is_also_missing()
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
    public function admin_business_creation_validation_fails_if_user_does_not_exist()
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
    public function admin_business_creation_validation_fails_if_company_is_missing_when_user_is_also_missing()
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
    public function admin_business_creation_validation_fails_if_company_does_not_exist()
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
    public function admin_business_creation_validation_fails_if_contact_does_not_exist()
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
    public function admin_business_creation_validation_fails_if_folder_color_is_invalid()
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

    /** @test */
    public function user_business_creation_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => '',
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => 123,
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => str_repeat('a', 2),
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => str_repeat('a', 46),
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 123,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => str_repeat('a', 256),
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_contact_is_missing()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => '',
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('contact_id');
        $this->assertCount(0, Business::all());
    }

    /** @test */
    public function user_business_creation_validation_fails_if_contact_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => 999,
            'folder_color' => 'red',
        ]);
        $response->assertJsonValidationErrors('contact_id');
        $this->assertCount(0, Business::all());
    }
    
    /** @test */
    public function user_business_creation_validation_fails_if_folder_color_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Business::all());

        $response = $this->postJson(route('businesses.store'), [
            'name' => "Fête de l'Hiver",
            'description' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'folder_color' => 'invalid',
        ]);
        $response->assertJsonValidationErrors('folder_color');
        $this->assertCount(0, Business::all());
    }
}
