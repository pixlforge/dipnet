<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create an Article for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();

        return $this->article = factory('App\Article')->create();
    }

    /** @test */
    function article_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $this->get(route('articles.index'))
            ->assertViewIs('articles.index');
    }

    /** @test */
    function authorized_users_can_create_articles()
    {
        $this->signIn(null, 'administrateur');

        $category = factory('App\Category')->create();

        $article = factory('App\Article')->make(['category' => $category->id]);

        $this->post(route('articles.store'), $article->toArray())
            ->assertRedirect(route('articles.index'));
    }

    /** @test */
    function authorized_users_can_update_articles()
    {
        $this->signIn(null, 'administrateur');

        $category = factory('App\Category')->create();

        $article = factory('App\Article')->make(['category' => $category->id]);

        $this->post(route('articles.store'), $article->toArray())
            ->assertRedirect(route('articles.index'));

        $article->description = 'Lorem Ipsum dolor sit amet';

        $this->put("/articles/{$article->reference}", $article->toArray())
            ->assertRedirect(route('articles.index'));
    }

    /** @test */
    function authorized_users_can_delete_articles()
    {
        $this->signIn(null, 'administrateur');

        $article = factory('App\Article')->create();

        $this->assertDatabaseHas('articles', ['reference' => $article->reference]);

        $this->delete("/articles/{$article->reference}")
            ->assertRedirect(route('articles.index'));
    }
}