<?php

namespace Tests\Feature;

use App\User;
use App\Article;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_all_articles()
    {
        $user = factory(User::class)->create(['role' => 'administrateur']);
        $this->signIn($user);

        $article = factory(Article::class)->create(['reference' => '85erfgbn']);

        $this->get(route('articles.index'))
            ->assertStatus(200)
            ->assertSee('85erfgbn');
    }

    /** @test */
    function an_admin_can_create_new_articles()
    {
        $user = factory(User::class)->create(['role' => 'administrateur']);
        $this->signIn($user);

        $category = factory(Category::class)->create();

        $this->postJson(route('articles.store'), [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'category_id' => $category->id
        ])->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'category_id' => $category->id
        ]);
    }

    /** @test */
    function an_article_can_be_updated()
    {
        $user = factory(User::class)->states(['admin'])->create();
        $this->signIn($user);

        $category = factory(Category::class)->create();

        $this->postJson(route('articles.store'), [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'category_id' => $category->id
        ])->assertStatus(200);

        $article = Article::whereReference('85erfgbn')->first();

        $this->putJson(route('articles.update', $article), [
            'reference' => '85ERFGBN',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'category_id' => $category->id
        ])->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'reference' => '85ERFGBN',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'category_id' => $category->id
        ]);
    }

    /** @test */
    function an_article_can_be_deleted()
    {
        $user = factory(User::class)->states(['admin'])->create();
        $this->signIn($user);

        $category = factory(Category::class)->create();

        $this->postJson(route('articles.store'), [
            'reference' => '85erfgbn',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'category_id' => $category->id
        ])->assertStatus(200);

        $article = Article::whereReference('85erfgbn')->first();

        $this->deleteJson(route('articles.destroy', $article))
            ->assertStatus(204);
        $this->assertNotNull($article->fresh()->deleted_at);
    }
}