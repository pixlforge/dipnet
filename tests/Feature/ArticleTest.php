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
     * Article views are available
     *
     * @test
     */
    function article_views_are_available()
    {
        $response = $this->get('/articles');
        $response->assertViewIs('articles.index');

        $response = $this->get('/articles/create');
        $response->assertViewIs('articles.create');

        $response = $this->get('/articles/article-id');
        $response->assertViewIs('articles.show');

        $response = $this->get('/articles/article-id/edit');
        $response->assertViewIs('articles.edit');
    }

    /**
     * An article can be inserted into the database
     *
     * @test
     */
    function an_article_can_be_inserted_into_the_database()
    {
        $article = factory('App\Article')->create();
        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }
}
