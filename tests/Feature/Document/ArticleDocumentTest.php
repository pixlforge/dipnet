<?php

namespace Tests\Feature\Document;

use App\User;
use App\Order;
use App\Article;
use App\Delivery;
use App\Document;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleDocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_document_can_be_updated_by_an_admin_with_multiple_options()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $document = factory(Document::class)->create();
        $article1 = factory(Article::class)->create([
            'description' => 'Reliure Wiro',
            'type' => 'option'
        ]);
        $article2 = factory(Article::class)->create([
            'description' => 'Vernis UV',
            'type' => 'option'
        ]);

        $this->assertCount(0, $document->articles);

        $this->patchJson(route('documents.update',[
            $document->delivery->order,
            $document->delivery,
            $document
        ]), [
            'finish' => 'plié',
            'quantity' => 3,
            'options' => [$article1->id, $article2->id]
        ])->assertStatus(200);

        $this->assertCount(2, $document->fresh()->articles);
    }

    /** @test */
    function a_documents_options_can_be_cloned_to_those_related_to_the_same_delivery()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $articleOne = factory(Article::class)->create([
            'description' => 'Reliure Wiro',
            'type' => 'option'
        ]);
        $articleTwo = factory(Article::class)->create([
            'description' => 'Vernis UV',
            'type' => 'option'
        ]);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'order_id' => $order->id
        ]);

        $documentOne = factory(Document::class)->create([
            'delivery_id' => $delivery->id
        ]);
        $documentTwo = factory(Document::class)->create([
            'delivery_id' => $delivery->id
        ]);
        $documentThree = factory(Document::class)->create([
            'delivery_id' => $delivery->id
        ]);

        $this->assertCount(0, $documentOne->articles);
        $this->assertCount(0, $documentTwo->articles);
        $this->assertCount(0, $documentThree->articles);

        $this->patchJson(route('documents.update',[
            $documentOne->delivery->order,
            $documentOne->delivery,
            $documentOne
        ]), [
            'finish' => 'plié',
            'options' => [$articleOne->id, $articleTwo->id],
            'quantity' => 3
        ])->assertStatus(200);

        $this->assertCount(2, $documentOne->fresh()->articles);

        // Cloning options
        $this->postJson(route('documents.clone.options', [
            $order,
            $delivery
        ]), [
            'finish' => 'plié',
            'options' => [$articleOne->id, $articleTwo->id],
            'quantity' => 3
        ])->assertStatus(200);

        $this->assertCount(2, $documentTwo->fresh()->articles);
        $this->assertCount(2, $documentThree->fresh()->articles);
    }
}
