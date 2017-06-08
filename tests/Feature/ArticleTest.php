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
        $response = $this->get('/articles');
        $response->assertViewIs('articles.index');
    }

    /**
     * Article create view is available
     *
     * @test
     */
    function article_create_view_is_available()
    {
        $response = $this->get('/articles/create');
        $response->assertViewIs('articles.create');
    }
    
    /**
     * Article show view is available and requires an article
     * 
     * @test
     */
    function article_show_view_is_available_and_requires_an_article()
    {
        $response = $this->get('/articles/' . $this->article->reference);
        $response->assertViewIs('articles.show');
    }

    /**
     * Article edit view is available and requires an article
     *
     * @test
     */
    function article_edit_view_is_available_and_requires_an_article()
    {
        $response = $this->get('/articles/' . $this->article->reference . '/edit');
        $response->assertViewIs('articles.edit');
    }
}



















