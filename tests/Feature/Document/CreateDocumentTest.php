<?php

namespace Tests\Feature\Document;

use Dipnet\User;
use Dipnet\Order;
use Tests\TestCase;
use Dipnet\Contact;
use Dipnet\Delivery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $contact = factory(Contact::class)->create();
        $this->order = factory(Order::class)->create();
        $this->delivery = factory(Delivery::class)->create([
            'order_id' => $this->order->id,
            'contact_id' => $contact->id
        ]);
        $this->endpoint = ['order' => $this->order->reference, 'delivery' => $this->delivery->reference];
    }

    /** @test */
    function users_can_add_a_new_document_to_a_delivery()
    {
        Storage::fake('local');

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->actingAs($user);

        $this->assertCount(0, $this->delivery->documents);

        $this->postJson(route('documents.store', $this->endpoint), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ]);

        Storage::disk('local')
            ->assertExists("orders/{$this->order->reference}/{$this->delivery->reference}/flyer-2018.pdf");
        $this->assertCount(1, $this->delivery->fresh()->documents);
    }

    /** @test */
    function document_validation_fails_if_the_user_uploads_a_zip()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->actingAs($user);

        $this->assertCount(0, $this->delivery->documents);

        $this->postJson(route('documents.store', $this->endpoint), [
            'file' => UploadedFile::fake()->create('flyer-2018.zip')
        ])->assertStatus(422);

        Storage::disk('local')
            ->assertMissing("orders/{$this->order->reference}/{$this->delivery->reference}/flyer-2018.zip");
        $this->assertCount(0, $this->delivery->fresh()->documents);
    }

    /** @test */
    function document_validation_fails_if_the_user_uploads_a_rar()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->actingAs($user);

        $this->assertCount(0, $this->delivery->documents);

        $this->postJson(route('documents.store', $this->endpoint), [
            'file' => UploadedFile::fake()->create('flyer-2018.rar')
        ])->assertStatus(422);

        Storage::disk('local')
            ->assertMissing("orders/{$this->order->reference}/{$this->delivery->reference}/flyer-2018.rar");
        $this->assertCount(0, $this->delivery->fresh()->documents);
    }

    /** @test */
    function guests_cannot_upload_documents()
    {
        $this->withExceptionHandling();

        Storage::fake('local');

        $this->assertCount(0, $this->delivery->documents);

        $this->postJson(route('documents.store', $this->endpoint), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ])->assertStatus(401);

        Storage::disk('local')
            ->assertMissing("orders/{$this->order->reference}/{$this->delivery->reference}/flyer-2018.pdf");
        $this->assertCount(0, $this->delivery->fresh()->documents);
    }
}
