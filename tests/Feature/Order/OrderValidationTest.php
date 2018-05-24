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
    public function guests_cannot_validate_orders()
    {
        $this->withExceptionHandling();

        $order = factory(Order::class)->create();

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(401);
    }

    /** @test */
    public function validation_fails_if_there_is_no_delivery()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();
        $this->assertEquals('incomplète', $order->status);
        $this->assertCount(0, $order->deliveries);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function validation_passes_if_there_is_at_least_one_delivery_associated()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();
        $this->assertEquals('incomplète', $order->status);
        $this->assertCount(0, $order->deliveries);

        $delivery = factory(Delivery::class)->create([
            'order_id' => $order->id
        ]);

        factory(Document::class)->create([
            'delivery_id' => $delivery->id
        ]);

        $this->assertCount(1, $order->fresh()->deliveries);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(200);
    }

    /** @test */
    public function validation_fails_if_there_is_no_document_associated_to_a_delivery()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();

        factory(Delivery::class)->create([
            'order_id' => $order->id
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_order_is_not_incomplete_before_validation()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create([
            'status' => 'envoyée'
        ]);
        $this->assertEquals('envoyée', $order->status);

        factory(Delivery::class)->create([
            'order_id' => $order->id
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_the_order_is_not_associated_with_a_business()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create([
            'business_id' => null
        ]);
        $this->assertEquals('incomplète', $order->status);

        factory(Delivery::class)->create([
            'order_id' => $order->id
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_the_order_is_not_associated_with_a_contact()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create([
            'contact_id' => null
        ]);
        $this->assertEquals('incomplète', $order->status);

        factory(Delivery::class)->create([
            'order_id' => $order->id
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_the_order_contains_a_delivery_not_associated_with_any_delivery_contact()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();
        factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => $this->contact
        ]);
        factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => null
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_the_order_contains_a_delivery_without_a_delivery_date()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();
        factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => $this->contact
        ]);
        factory(Delivery::class)->create([
            'order_id' => $order->id,
            'contact_id' => $this->contact,
            'to_deliver_at' => null
        ]);

        $this->postJson(route('orders.validation', $order), $order->toArray())
            ->assertStatus(422);
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
