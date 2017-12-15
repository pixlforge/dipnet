<?php

namespace Tests\Feature\Document;

use Dipnet\Article;
use Dipnet\Document;
use Dipnet\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
