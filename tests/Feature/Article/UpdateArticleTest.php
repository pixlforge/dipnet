<?php

namespace Tests\Feature\Article;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_existing_articles()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create();

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE123',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertSuccessful();

        $article = Article::first();
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Lorem isum dolor sit amet', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(true, $article->greyscale);
    }

    /** @test */
    public function users_cannot_update_existing_articles()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $article = factory(Article::class)->create();

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE123',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_update_existing_articles()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $article = factory(Article::class)->create();

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE123',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'impression',
            'greyscale' => true,
        ]);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function update_articles_validation_fails_if_reference_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('reference');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_reference_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 123,
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('reference');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_reference_is_already_in_use()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $articleA = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $articleB = factory(Article::class)->create([
            'reference' => 'REFERENCE456',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $articleB), [
            'reference' => 'REFERENCE123',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('reference');

        $article = Article::find($articleB->id);
        $this->assertEquals('REFERENCE456', $articleB->reference);
        $this->assertEquals('Some description', $articleB->description);
        $this->assertEquals('impression', $articleB->type);
        $this->assertEquals(false, $articleB->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_reference_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => str_repeat('a', 2),
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('reference');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_reference_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => str_repeat('a', 46),
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('reference');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => 123,
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('description');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_description_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => str_repeat('a', 2),
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('description');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_description_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => str_repeat('a', 46),
            'type' => 'option',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('description');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_type_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => 'Lorem isum dolor sit amet',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('type');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_type_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 123,
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('type');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_type_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'something-else',
            'greyscale' => true,
        ]);
        $response->assertJsonValidationErrors('type');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_greyscale_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
        ]);
        $response->assertJsonValidationErrors('greyscale');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }

    /** @test */
    public function update_articles_validation_fails_if_greyscale_is_not_a_boolean()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $article = factory(Article::class)->create([
            'reference' => 'REFERENCE123',
            'description' => 'Some description',
            'type' => 'impression',
            'greyscale' => false,
        ]);

        $response = $this->patchJson(route('admin.articles.update', $article), [
            'reference' => 'REFERENCE456',
            'description' => 'Lorem isum dolor sit amet',
            'type' => 'option',
            'greyscale' => 'true',
        ]);
        $response->assertJsonValidationErrors('greyscale');

        $article = Article::find($article->id);
        $this->assertEquals('REFERENCE123', $article->reference);
        $this->assertEquals('Some description', $article->description);
        $this->assertEquals('impression', $article->type);
        $this->assertEquals(false, $article->greyscale);
    }
}
