<?php

namespace Tests\Feature\Business;

use App\User;
use App\Company;
use App\Contact;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_existing_admin_businesses_associated_with_a_company()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
        
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertOk();

        $business = $business->fresh();
        $this->assertEquals("Fête de l'Hiver", $business->name);
        $this->assertEquals("It'll change your entire perspective.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($otherCompany->id, $business->company_id);
        $this->assertEquals('blue', $business->folder_color);
    }

    /** @test */
    public function admins_can_update_existing_admin_businesses_associated_with_a_user()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'user_id' => $user->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'user_id' => $otherUser->id,
            'folder_color' => 'blue',
        ]);
        $response->assertOk();

        $business = $business->fresh();
        $this->assertEquals("Fête de l'Hiver", $business->name);
        $this->assertEquals("It'll change your entire perspective.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals($otherUser->id, $business->user_id);
        $this->assertEquals(null, $business->company_id);
        $this->assertEquals(null, $business->contact_id);
        $this->assertEquals('blue', $business->folder_color);
    }

    /** @test */
    public function admins_can_update_existing_admin_businesses_associated_with_a_solo_user_and_associate_them_with_a_contact()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $contact = factory(Contact::class)->create(['user_id' => $otherUser->id]);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'user_id' => $user->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'user_id' => $otherUser->id,
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertOk();

        $business = $business->fresh();
        $this->assertEquals("Fête de l'Hiver", $business->name);
        $this->assertEquals("It'll change your entire perspective.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals($otherUser->id, $business->user_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals(null, $business->company_id);
        $this->assertEquals('blue', $business->folder_color);
    }

    /** @test */
    public function users_cannot_update_existing_admin_businesses()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertForbidden();

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function guests_cannot_update_existing_admin_businesses()
    {
        $this->withExceptionHandling();

        $this->assertGuest();
        
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertRedirect(route('login'));

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => '',
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => 123,
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => str_repeat('a', 2),
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => str_repeat('a', 46),
            'description' => "It'll change your entire perspective.",
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => 123,
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('description');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => str_repeat('a', 256),
            'company_id' => $otherCompany->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('description');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_user_is_missing_when_company_is_also_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $user = factory(User::class)->states('user')->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'user_id' => $user->id,
            'company_id' => null,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'user_id' => null,
            'company_id' => null,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('user_id');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals($user->id, $business->user_id);
        $this->assertEquals(null, $business->company_id);
        $this->assertEquals($user->id, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_user_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $user = factory(User::class)->states('user')->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'user_id' => $user->id,
            'company_id' => null,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'user_id' => 999,
            'company_id' => null,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('user_id');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals($user->id, $business->user_id);
        $this->assertEquals(null, $business->company_id);
        $this->assertEquals($user->id, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_company_is_missing_when_user_is_also_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'user_id' => null,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'user_id' => null,
            'company_id' => null,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('company_id');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'user_id' => null,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'user_id' => null,
            'company_id' => 999,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('company_id');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_contact_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'user_id' => null,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'company_id' => $company->id,
            'user_id' => null,
            'contact_id' => 999,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('contact_id');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_folder_color_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'user_id' => null,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'company_id' => $company->id,
            'user_id' => null,
            'folder_color' => '',
        ]);
        $response->assertJsonValidationErrors('folder_color');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_admin_businesses_validation_fails_if_folder_color_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    
        $company = factory(Company::class)->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'user_id' => null,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('admin.businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'company_id' => $company->id,
            'user_id' => null,
            'folder_color' => 'something-wrong',
        ]);
        $response->assertJsonValidationErrors('folder_color');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function users_associated_with_a_company_can_update_their_own_businesses()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        
        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'folder_color' => 'red',
            'company_id' => $company->id
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'folder_color' => 'blue',
        ]);
        $response->assertOk();

        $business = $business->fresh();
        $this->assertEquals("Fête de l'Hiver", $business->name);
        $this->assertEquals("It'll change your entire perspective.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('blue', $business->folder_color);
    }

    /** @test */
    public function solo_users_can_update_their_own_businesses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'folder_color' => 'red',
            'user_id' => $user->id
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'folder_color' => 'blue',
        ]);
        $response->assertOk();

        $business = $business->fresh();
        $this->assertEquals("Fête de l'Hiver", $business->name);
        $this->assertEquals("It'll change your entire perspective.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals($user->id, $business->user_id);
        $this->assertNull($business->company_id);
        $this->assertEquals('blue', $business->folder_color);
    }

    /** @test */
    public function guests_cannot_update_existing_user_businesses()
    {
        $this->withExceptionHandling();

        $this->assertGuest();
        
        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'folder_color' => 'red',
            'company_id' => $company->id
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'folder_color' => 'blue',
        ]);
        $response->assertStatus(401);

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function users_associated_with_a_company_cannot_update_others_businesses()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        
        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'folder_color' => 'red',
            'company_id' => $otherCompany->id
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'folder_color' => 'blue',
        ]);
        $response->assertForbidden();

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($otherCompany->id, $business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function solo_users_cannot_update_others_businesses()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $otherUser = factory(User::class)->states('user', 'solo')->create();

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'folder_color' => 'red',
            'user_id' => $otherUser->id
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'folder_color' => 'blue',
        ]);
        $response->assertForbidden();

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals($otherUser->id, $business->user_id);
        $this->assertNull($business->company_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => '',
            'description' => "It'll change your entire perspective.",
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => 123,
            'description' => "It'll change your entire perspective.",
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => str_repeat('a', 2),
            'description' => "It'll change your entire perspective.",
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => str_repeat('a', 46),
            'description' => "It'll change your entire perspective.",
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('name');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => 123,
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('description');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => str_repeat('a', 256),
            'contact_id' => $contact->id,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('description');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_contact_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'contact_id' => 999,
            'folder_color' => 'blue',
        ]);
        $response->assertJsonValidationErrors('contact_id');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_folder_color_is_missing()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'contact_id' => $company->id,
            'folder_color' => '',
        ]);
        $response->assertJsonValidationErrors('folder_color');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }

    /** @test */
    public function update_user_businesses_validation_fails_if_folder_color_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $business = factory(Business::class)->create([
            'name' => 'Fête Nationale',
            'description' => "In life you need colors. Just take out whatever you don't want.",
            'reference' => 'KPLQMRLJ',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'folder_color' => 'red',
        ]);

        $response = $this->patchJson(route('businesses.update', $business), [
            'name' => "Fête de l'Hiver",
            'description' => "It'll change your entire perspective.",
            'contact_id' => $company->id,
            'folder_color' => 'something-wrong',
        ]);
        $response->assertJsonValidationErrors('folder_color');

        $business = $business->fresh();
        $this->assertEquals('Fête Nationale', $business->name);
        $this->assertEquals("In life you need colors. Just take out whatever you don't want.", $business->description);
        $this->assertEquals('KPLQMRLJ', $business->reference);
        $this->assertEquals(null, $business->user_id);
        $this->assertEquals($company->id, $business->company_id);
        $this->assertEquals($contact->id, $business->contact_id);
        $this->assertEquals('red', $business->folder_color);
    }
}
