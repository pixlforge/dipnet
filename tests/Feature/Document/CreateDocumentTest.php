<?php

namespace Tests\Feature\Document;

use App\User;
use App\Order;
use App\Company;
use App\Delivery;
use App\Document;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_can_add_new_documents()
    {
        $this->withoutExceptionHandling();

        Storage::fake('local');

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertCount(0, Document::all());

        $response = $this->postJson(route('documents.store', $delivery), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ]);

        $response->assertOk();
        $this->assertCount(1, Document::all());

        $document = Document::first();
        $this->assertFileExists($document->getFirstMedia('documents')->getPath());
        $this->assertEquals($delivery->id, $document->delivery->id);
    }

    /** @test */
    public function solo_users_can_add_new_documents()
    {
        $this->withoutExceptionHandling();

        Storage::fake('local');

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['user_id' => $user->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertCount(0, Document::all());

        $response = $this->postJson(route('documents.store', $delivery), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ]);

        $response->assertOk();
        $this->assertCount(1, Document::all());

        $document = Document::first();
        $this->assertFileExists($document->getFirstMedia('documents')->getPath());
        $this->assertEquals($delivery->id, $document->delivery->id);
    }

    /** @test */
    public function guests_cannot_add_new_documents()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $this->assertGuest();

        $company = factory(Company::class)->create();
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertCount(0, Document::all());

        $response = $this->postJson(route('documents.store', $delivery), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ]);

        $response->assertStatus(401);
        $this->assertCount(0, Document::all());
    }

    /** @test */
    public function users_cannot_add_documents_to_others_deliveries()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertCount(0, Document::all());

        $response = $this->postJson(route('documents.store', $delivery), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ]);

        $response->assertForbidden();
        $this->assertCount(0, Document::all());
    }

    /** @test */
    public function add_document_validation_fails_if_uploaded_file_is_a_zip()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertCount(0, Document::all());

        $response = $this->postJson(route('documents.store', $delivery), [
            'file' => UploadedFile::fake()->create('flyer-2018.zip')
        ]);

        $response->assertJsonValidationErrors('file');
        $this->assertCount(0, Document::all());
    }

    /** @test */
    public function add_document_validation_fails_if_uploaded_file_is_a_rar()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertCount(0, Document::all());

        $response = $this->postJson(route('documents.store', $delivery), [
            'file' => UploadedFile::fake()->create('flyer-2018.rar')
        ]);

        $response->assertJsonValidationErrors('file');
        $this->assertCount(0, Document::all());
    }
}
