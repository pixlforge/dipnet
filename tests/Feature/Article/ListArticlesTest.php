<?php

namespace Tests\Feature\Article;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_articles_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.articles.index'));
        $response->assertOk();
        $response->assertViewIs('admin.articles.index');
        $response->assertSee('Liste de tous les articles');
    }

    /** @test */
    public function users_cannot_access_the_articles_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.articles.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_articles_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.articles.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_articles_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Article::class, 25)->create();

        $articles = $this->getJson(route('api.articles.index'));
        $this->assertCount(25, $articles->getData()->data);
    }

    /** @test */
    public function users_cannot_fetch_articles_via_the_api()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->getJson(route('api.articles.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_fetch_articles_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->getJson(route('api.articles.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_articles_via_the_api_sorted_by_reference()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Article::class)->create(['reference' => 'KVNTJVML']);
        factory(Article::class)->create(['reference' => 'IUNSOXMG']);
        factory(Article::class)->create(['reference' => 'PWIMVTND']);
        factory(Article::class)->create(['reference' => 'ORMBIHEW']);
        factory(Article::class)->create(['reference' => 'ZRMXLVFQ']);

        $response = $this->getJson(route('api.articles.index', 'reference'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'IUNSOXMG',
            'KVNTJVML',
            'ORMBIHEW',
            'PWIMVTND',
            'ZRMXLVFQ',
        ]);
    }

    /** @test */
    public function admins_can_fetch_articles_via_the_api_sorted_by_description()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Article::class)->create(['description' => 'B random description']);
        factory(Article::class)->create(['description' => 'D random description']);
        factory(Article::class)->create(['description' => 'C random description']);
        factory(Article::class)->create(['description' => 'E random description']);
        factory(Article::class)->create(['description' => 'A random description']);

        $response = $this->getJson(route('api.articles.index', 'description'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'A random description',
            'B random description',
            'C random description',
            'D random description',
            'E random description',
        ]);
    }

    /** @test */
    public function admins_can_fetch_articles_via_the_api_sorted_by_type()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Article::class)->create(['type' => 'impression']);
        factory(Article::class)->create(['type' => 'option']);
        factory(Article::class)->create(['type' => 'impression']);
        factory(Article::class)->create(['type' => 'option']);
        factory(Article::class)->create(['type' => 'impression']);

        $response = $this->getJson(route('api.articles.index', 'type'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'impression',
            'impression',
            'impression',
            'option',
            'option',
        ]);
    }

    /** @test */
    public function admins_can_fetch_articles_via_the_api_sorted_by_greyscale()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Article::class)->create(['greyscale' => true]);
        factory(Article::class)->create(['greyscale' => false]);
        factory(Article::class)->create(['greyscale' => true]);
        factory(Article::class)->create(['greyscale' => false]);
        factory(Article::class)->create(['greyscale' => true]);

        $response = $this->getJson(route('api.articles.index', 'greyscale'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'greyscale' => true,
            'greyscale' => true,
            'greyscale' => false,
            'greyscale' => false,
            'greyscale' => false,
        ]);
    }

    /** @test */
    public function admins_can_fetch_articles_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Article::class)->create([
            'description' => 'A random description',
            'created_at' => now()->subMonth(),
        ]);
        factory(Article::class)->create([
            'description' => 'B random description',
            'created_at' => now()->addMonth(),
        ]);
        factory(Article::class)->create([
            'description' => 'C random description',
            'created_at' => now()->subYear(),
        ]);
        factory(Article::class)->create([
            'description' => 'D random description',
            'created_at' => now()->addYear(),
        ]);
        factory(Article::class)->create([
            'description' => 'E random description',
            'created_at' => now(),
        ]);

        $response = $this->getJson(route('api.articles.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'D random description',
            'B random description',
            'E random description',
            'A random description',
            'C random description',
        ]);
    }
}
