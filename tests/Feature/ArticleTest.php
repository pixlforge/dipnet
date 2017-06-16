<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    use DatabaseMigrations;

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

    /**
     * Article index view is available
     *
     * @test
     */
    function article_index_view_is_available()
    {
        $this->signIn();

        $this->get('/articles')
            ->assertViewIs('articles.index');
    }

    /**
     * Article create view is available
     *
     * @test
     */
    function article_create_view_is_available()
    {
        $this->signIn();

        $this->get('/articles/create')
            ->assertViewIs('articles.create');
    }

    /**
     * Article edit view is available and requires an article
     *
     * @test
     */
    function article_edit_view_is_available_and_requires_an_article()
    {
        $this->signIn();

        $this->get('/articles/' . $this->article->reference . '/edit')
            ->assertViewIs('articles.edit');
    }
    
    /**
     * Authorized users can create articles
     * 
     * @test
     */
    function authorized_users_can_create_articles()
    {
        $this->signIn();

        $category = factory('App\Category')->create();

        $article = factory('App\Article')->make(['category' => $category->id]);

        $this->post('/articles', $article->toArray())
            ->assertRedirect('/articles');
    }

    /**
     * Authorized users can update articles
     *
     * @test
     */
    function authorized_users_can_update_articles()
    {
        $this->signIn();

        $category = factory('App\Category')->create();

        $article = factory('App\Article')->make(['category' => $category->id]);

        $this->post('/articles', $article->toArray())
            ->assertRedirect('/articles');

        $article->description = 'Lorem Ipsum dolor sit amet';

        $this->put("/articles/{$article->reference}", $article->toArray())
            ->assertRedirect('/articles');
    }

    /**
     * Authorized users can delete articles
     *
     * @test
     */
    function authorized_users_can_delete_articles()
    {
        $this->signIn();

        $article = factory('App\Article')->create();

        $this->assertDatabaseHas('articles', ['reference' => $article->reference]);

        $this->delete("/articles/{$article->reference}")
            ->assertRedirect('articles');
    }

    /**
     * Authorized users can restore artices
     *
     * @test
     */
    function authorized_users_can_restore_articles()
    {
        $this->signIn();

        $article = factory('App\Article')->create();

        $this->assertDatabaseHas('articles', ['reference' => $article->reference]);

        $this->delete("/articles/{$article->reference}")
            ->assertRedirect('articles');

        $this->put("/articles/{$article->reference}/restore", [$article])
            ->assertRedirect('articles');
    }

}



















