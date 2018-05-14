<?php

namespace Tests\Feature\Article;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_reach_the_articles_index_view()
    {
        $user = factory(User::class)->create(['role' => 'administrateur']);
        $this->signIn($user);

        $this->get(route('articles.index'))
            ->assertStatus(200);
    }

    /** @test */
    function an_admin_can_create_new_articles()
    {
        $user = factory(User::class)->create(['role' => 'administrateur']);
        $this->signIn($user);

        $this->postJson(route('articles.store'), [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true
        ])->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression'
        ]);
    }

    /** @test */
    function an_article_can_be_updated()
    {
        $user = factory(User::class)->states(['admin'])->create();
        $this->signIn($user);

        $this->postJson(route('articles.store'), [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true
        ])->assertStatus(200);

        $article = Article::whereReference('85erfgbn')->first();

        $this->putJson(route('articles.update', $article), [
            'reference' => '85ERFGBN',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => false
        ])->assertStatus(200);

        $this->assertEquals(false, $article->fresh()->greyscale);
    }

    /** @test */
    function an_article_can_be_deleted()
    {
        $user = factory(User::class)->states(['admin'])->create();
        $this->signIn($user);

        $this->postJson(route('articles.store'), [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ])->assertStatus(200);

        $article = Article::whereReference('85erfgbn')->first();

        $this->deleteJson(route('articles.destroy', $article))
            ->assertStatus(204);
        $this->assertNotNull($article->fresh()->deleted_at);
    }
}