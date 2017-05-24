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
