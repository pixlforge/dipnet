<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use App\Contact;
use App\Delivery;
use App\Document;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->contact = factory(Contact::class)->create();
    }

    /** @test */
    public function validation_fails_if_a_delivery_contains_a_document_without_a_print_article()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => $this->contact
        ]);
        factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => $this->contact
        ]);

        factory(Document::class)->create([
            'article_id' => null,
            'delivery_id' => $delivery->id
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }
}
