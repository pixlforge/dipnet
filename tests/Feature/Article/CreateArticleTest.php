<?php

namespace Tests\Feature\Article;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_new_articles()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertSuccessful();
        $this->assertCount(1, Article::all());
    }

    /** @test */
    public function users_cannot_create_new_articles()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertForbidden();
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function guests_cannot_create_new_articles()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertRedirect(route('login'));
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 123,
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_description_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => str_repeat('a', 2),
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => str_repeat('a', 101),
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_type_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem ipsum dolor sit amet.',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('type');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_type_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem ipsum dolor sit amet.',
            'type' => 123,
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('type');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_type_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem ipsum dolor sit amet.',
            'type' => 'wrong-type',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('type');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_greyscale_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem ipsum dolor sit amet.',
            'type' => 'impression',
        ]);
        $response->assertJsonValidationErrors('greyscale');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function new_articles_creation_validation_fails_if_greyscale_is_not_a_boolean()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Article::all());

        $response = $this->postJson(route('admin.articles.store'), [
            'description' => 'Lorem ipsum dolor sit amet.',
            'type' => 'impression',
            'greyscale' => 'ok',
        ]);
        $response->assertJsonValidationErrors('greyscale');
        $this->assertCount(0, Article::all());
    }
}
