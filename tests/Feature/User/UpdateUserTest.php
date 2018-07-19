<?php

namespace Tests\Feature\User;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_existing_users()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $companyA = factory(Company::class)->create(['name' => 'CompanyA']);
        $companyB = factory(Company::class)->create(['name' => 'CompanyB']);
        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
            'company_id' => $companyA->id,
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
            'company_id' => $companyB->id,
        ]);

        $response->assertOk();
        $user = $user->fresh();
        $this->assertEquals('Jane Doe', $user->username);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
        $this->assertEquals($companyB->id, $user->company->id);
    }

    /** @test */
    public function users_cannot_update_existing_users()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $otherUser = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $otherUser), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertForbidden();
        $otherUser = $otherUser->fresh();
        $this->assertEquals('John Doe', $otherUser->username);
        $this->assertEquals('john@example.com', $otherUser->email);
        $this->assertEquals('utilisateur', $otherUser->role);
    }

    /** @test */
    public function guests_cannot_update_existing_users()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertRedirect(route('login'));
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function users_promoted_to_admin_are_not_associated_with_a_company()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $this->assertNotNull($user->company_id);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'administrateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertOk();
        $user = $user->fresh();
        $this->assertEquals('Jane Doe', $user->username);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('administrateur', $user->role);
        $this->assertNull($user->company->id);
    }

    /** @test */
    public function users_promoted_to_admin_are_not_solo()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states(['user', 'solo'])->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $this->assertTrue($user->is_solo);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'administrateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertOk();
        $user = $user->fresh();
        $this->assertEquals('Jane Doe', $user->username);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('administrateur', $user->role);
        $this->assertFalse($user->is_solo);
    }

    /** @test */
    public function users_previously_associated_with_a_company_are_considered_solo()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
            'company_id' => $company->id,
        ]);

        $this->assertNotNull($user->company_id);
        $this->assertFalse($user->is_solo);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertOk();
        $user = $user->fresh();
        $this->assertEquals('Jane Doe', $user->username);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
        $this->assertNull($user->company_id);
        $this->assertTrue($user->is_solo);
    }

    /** @test */
    public function previously_solo_users_updated_with_a_company_are_not_considered_solo_anymore()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create();

        $user = factory(User::class)->states('solo')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $this->assertNull($user->company_id);
        $this->assertTrue($user->is_solo);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
            'company_id' => $company->id,
        ]);

        $response->assertOk();
        $user = $user->fresh();
        $this->assertEquals('Jane Doe', $user->username);
        $this->assertEquals('jane@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
        $this->assertNotNull($user->company_id);
        $this->assertFalse($user->is_solo);
    }

    /** @test */
    public function update_user_validation_fails_if_username_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => '',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertJsonValidationErrors('username');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_username_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 123,
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertJsonValidationErrors('username');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_username_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => str_repeat('a', 2),
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertJsonValidationErrors('username');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_username_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => str_repeat('a', 256),
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'somethingelse',
            'password_confirmation' => 'somethingelse',
        ]);

        $response->assertJsonValidationErrors('username');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_password_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 123,
            'password_confirmation' => 123,
        ]);

        $response->assertJsonValidationErrors('password');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_password_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => str_repeat('a', 5),
            'password_confirmation' => str_repeat('a', 5),
        ]);

        $response->assertJsonValidationErrors('password');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_passwords_do_not_match()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
            'password_confirmation' => 'something-else',
        ]);

        $response->assertJsonValidationErrors('password');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_role_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => '',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertJsonValidationErrors('role');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_role_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => 'something-else',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertJsonValidationErrors('role');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_email_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => '',
            'role' => 'utilisateur',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertJsonValidationErrors('email');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_email_format_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example',
            'role' => 'utilisateur',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertJsonValidationErrors('email');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_email_is_already_in_use()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class)->states('user')->create(['email' => 'jane@example.com']);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => 'jane@example',
            'role' => 'utilisateur',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertJsonValidationErrors('email');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_email_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => str_repeat('a', 244) . '@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertJsonValidationErrors('email');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }

    /** @test */
    public function update_user_validation_fails_if_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $user = factory(User::class)->states('user')->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
        ]);

        $response = $this->patchJson(route('admin.users.update', $user), [
            'username' => 'Jane Doe',
            'email' => str_repeat('a', 244) . '@example.com',
            'role' => 'utilisateur',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'company_id' => 999,
        ]);

        $response->assertJsonValidationErrors('company_id');
        $user = $user->fresh();
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('utilisateur', $user->role);
    }
}
