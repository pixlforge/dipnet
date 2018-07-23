<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_users_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.users.index'));
        $response->assertOk();
        $response->assertViewIs('admin.users.index');
        $response->assertSee('Liste de tous les utilisateurs');
    }

    /** @test */
    public function users_cannot_access_the_users_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.users.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_users_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_users_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class, 24)->states('user')->create();

        $users = $this->getJson(route('api.users.index'));
        $this->assertCount(25, $users->getData()->data);
    }

    /** @test */
    public function users_cannot_fetch_users_via_the_api()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->getJson(route('api.users.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_fetch_users_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->getJson(route('api.users.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_users_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class)->states('user')->create(['username' => 'Bill']);
        factory(User::class)->states('user')->create(['username' => 'Zoey']);
        factory(User::class)->states('user')->create(['username' => 'Andy']);
        factory(User::class)->states('user')->create(['username' => 'Yann']);
        factory(User::class)->states('user')->create(['username' => 'Clara']);

        $response = $this->getJson(route('api.users.index', 'username'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Andy',
            'Bill',
            'Clara',
            'Yann',
            'Zoey',
        ]);
    }

    /** @test */
    public function admins_can_fetch_users_via_the_api_sorted_by_email()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class)->states('user')->create(['email' => 'bill@example.com']);
        factory(User::class)->states('user')->create(['email' => 'zoey@example.com']);
        factory(User::class)->states('user')->create(['email' => 'andy@example.com']);
        factory(User::class)->states('user')->create(['email' => 'yann@example.com']);
        factory(User::class)->states('user')->create(['email' => 'clara@example.com']);

        $response = $this->getJson(route('api.users.index', 'email'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'andy@example.com',
            'bill@example.com',
            'clara@example.com',
            'yann@example.com',
            'zoey@example.com',
        ]);
    }

    /** @test */
    public function admins_can_fetch_users_via_the_api_sorted_by_role()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class)->states('user')->create(['role' => 'utilisateur']);
        factory(User::class)->states('user')->create(['role' => 'administrateur']);
        factory(User::class)->states('user')->create(['role' => 'utilisateur']);
        factory(User::class)->states('user')->create(['role' => 'administrateur']);
        factory(User::class)->states('user')->create(['role' => 'utilisateur']);

        $response = $this->getJson(route('api.users.index', 'role'));

        $response->assertOk();
        $response->assertSeeInOrder([
            'utilisateur',
            'utilisateur',
            'utilisateur',
            'administrateur',
            'administrateur',
        ]);
    }

    /** @test */
    public function admins_can_fetch_users_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(User::class)->states('user')->create([
            'username' => 'The Hulk',
            'created_at' => now()->subDay()
        ]);
        factory(User::class)->states('user')->create([
            'username' => 'Thor',
            'created_at' => now()->subDays(3)
        ]);
        factory(User::class)->states('user')->create([
            'username' => 'Captain America',
            'created_at' => now()->addDays(3)
        ]);
        factory(User::class)->states('user')->create([
            'username' => 'Ironman',
            'created_at' => now()
        ]);
        factory(User::class)->states('user')->create([
            'username' => 'Spiderman',
            'created_at' => now()->subMinutes(45)
        ]);

        $response = $this->getJson(route('api.users.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Captain America',
            'Ironman',
            'Spiderman',
            'The Hulk',
            'Thor',
        ]);
    }
}
