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
}
