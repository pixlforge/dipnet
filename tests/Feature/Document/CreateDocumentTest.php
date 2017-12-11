<?php

namespace Tests\Feature\Document;

use Dipnet\User;
use Dipnet\Order;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Dipnet\Contact;
use Dipnet\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_add_a_new_document_to_a_delivery()
    {
        $this->withoutExceptionHandling();

        Storage::fake('local');

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
        $this->actingAs($user);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => $contact->id
        ]);
        $this->assertCount(0, $delivery->documents);

        $endpoint = ['order' => $order->reference, 'delivery' => $delivery->reference];
        $this->postJson(route('documents.store', $endpoint), [
            'file' => UploadedFile::fake()->create('flyer-2018.pdf')
        ]);

        Storage::disk('local')
            ->assertExists("orders/{$order->reference}/{$delivery->reference}/flyer-2018.pdf");
    }
}
