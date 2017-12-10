<?php

namespace Tests\Feature;

use App\Contact;
use App\Delivery;
use App\Order;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_add_a_new_document_to_a_delivery()
    {
        $this->withoutExceptionHandling();

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

        $endpoint = "/{$order->reference}/{$delivery->reference}";
        $this->postJson(route('documents.store', $endpoint), [

        ]);
    }
}
