<?php

namespace Tests\Feature\Article;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_delete_softly_existing_articles()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create();
        $this->assertNull($article->deleted_at);

        $response = $this->deleteJson(route('admin.articles.destroy', $article));
        $response->assertSuccessful();
        $this->assertNotNull($article->fresh()->deleted_at);
    }
}
