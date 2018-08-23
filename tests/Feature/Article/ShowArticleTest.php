<?php

namespace Tests\Feature\Article;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_article_show_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create();

        $response = $this->get(route('admin.articles.show', $article));

        $response->assertOk();
        $response->assertViewIs('admin.articles.show');
    }

    /** @test */
    public function users_cannot_access_the_articles_show_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $article = factory(Article::class)->create();

        $response = $this->get(route('admin.articles.show', $article));

        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_articles_show_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $article = factory(Article::class)->create();

        $response = $this->get(route('admin.articles.show', $article));

        $response->assertRedirect(route('login'));
    }
}
