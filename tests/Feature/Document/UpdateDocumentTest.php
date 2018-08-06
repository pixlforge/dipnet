<?php

namespace Tests\Feature\Document;

use App\User;
use App\Order;
use App\Company;
use App\Article;
use App\Delivery;
use App\Document;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_can_update_their_own_documents()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $optionA = factory(Article::class)->create(['type' => 'option']);
        $optionB = factory(Article::class)->create(['type' => 'option']);
        $optionC = factory(Article::class)->create(['type' => 'option']);

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id,
            'options' => [
                $optionA->id,
                $optionB->id,
                $optionC->id,
            ]
        ]);
        
        $response->assertOk();

        $document = $document->fresh();
        $this->assertEquals(210, $document->width);
        $this->assertEquals(297, $document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(5, $document->quantity);
        $this->assertEquals('plié', $document->finish);
        $this->assertEquals($article->id, $document->article->id);
        $this->assertEquals(3, $document->articles()->count());
    }

    /** @test */
    public function solo_users_can_update_their_own_documents()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['user_id' => $user->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertOk();

        $document = $document->fresh();
        $this->assertEquals(210, $document->width);
        $this->assertEquals(297, $document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(5, $document->quantity);
        $this->assertEquals('plié', $document->finish);
        $this->assertEquals($article->id, $document->article->id);
    }

    /** @test */
    public function users_cannot_update_documents_they_do_not_own()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $document = factory(Document::class)->create();
        $article = factory(Article::class)->create();

        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertForbidden();

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_width_is_not_an_integer()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210.5,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('width');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_width_is_not_minimum_1()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 0,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('width');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_height_is_not_an_integer()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297.5,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('height');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_height_is_not_minimum_1()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 0,
            'nb_orig' => null,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('height');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_nb_orig_is_not_an_integer()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => 10.5,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('nb_orig');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_nb_orig_is_not_minimum_1()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => 0,
            'quantity' => 5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('nb_orig');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_quantity_is_not_an_integer()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 5.5,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('quantity');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_quantity_is_not_minimum_1()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 0,
            'finish' => 'plié',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('quantity');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_finish_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 1,
            'finish' => 'invalid',
            'article_id' => $article->id
        ]);

        $response->assertJsonValidationErrors('finish');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_article_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 1,
            'finish' => 'plié',
            'article_id' => 999
        ]);

        $response->assertJsonValidationErrors('article_id');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }

    /** @test */
    public function update_document_validation_fails_if_options_are_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $article = factory(Article::class)->create();

        $optionA = factory(Article::class)->make([
            'id' => 997,
            'type' => 'option'
        ]);
        $optionB = factory(Article::class)->make([
            'id' => 998,
            'type' => 'option'
        ]);
        $optionC = factory(Article::class)->make([
            'id' => 999,
            'type' => 'option'
        ]);

        $this->assertCount(1, $order->deliveries->first()->documents);
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);

        $response = $this->patchJson(route('documents.update', $document), [
            'width' => 210,
            'height' => 297,
            'nb_orig' => null,
            'quantity' => 1,
            'finish' => 'plié',
            'article_id' => $article->id,
            'options' => [
                $optionA,
                $optionB,
                $optionC,
            ]
        ]);
        
        $response->assertJsonValidationErrors('options.0.id');
        $response->assertJsonValidationErrors('options.1.id');
        $response->assertJsonValidationErrors('options.2.id');

        $document = $document->fresh();
        $this->assertNull($document->width);
        $this->assertNull($document->height);
        $this->assertNull($document->nb_orig);
        $this->assertEquals(1, $document->quantity);
        $this->assertEquals('roulé', $document->finish);
        $this->assertEquals($delivery->id, $document->delivery->id);
        $this->assertNull($document->article_id);
    }
}
