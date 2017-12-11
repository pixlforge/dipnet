<?php

namespace Tests\Feature\Document;

use Dipnet\User;
use Dipnet\Order;
use Tests\TestCase;
use Dipnet\Company;
use Dipnet\Business;
use Dipnet\Delivery;
use Dipnet\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDocumentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test suite setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->order = factory(Order::class)->create();
        $this->delivery = factory(Delivery::class)->create([
            'order_id' => $this->order->id
        ]);
        $this->document = factory(Document::class)->create([
            'delivery_id' => $this->delivery->id
        ]);
        $this->endpoint = ['order' => $this->order->reference, 'delivery' => $this->delivery->reference];
    }

    /** @test */
    function users_can_delete_documents_from_a_delivery()
    {
        $user = factory(User::class)->create([
            'company_id' => function () {
                return factory(Company::class)->create()->id;
            }
        ]);

        $document = factory(Document::class)->create([
            'delivery_id' => function () use ($user) {
                return factory(Delivery::class)->create([
                    'order_id' => function () use ($user) {
                        return factory(Order::class)->create([
                            'business_id' => function () use ($user) {
                                return factory(Business::class)->create([
                                    'company_id' => $user->company->id
                                ])->id;
                            }
                        ])->id;
                    }
                ])->id;
            }
        ]);

        $this->actingAs($user);

        $delivery = Delivery::find(2);
        $this->assertCount(1, $delivery->documents);

        $this->deleteJson(route('documents.destroy', [
            $document->delivery->order->reference,
            $document->delivery->reference,
            $document
        ]))->assertStatus(204);

        $this->assertCount(0, $delivery->fresh()->documents);
    }

    /** @test */
    function guests_cannot_delete_documents_from_existing_deliveries()
    {
        $this->withExceptionHandling();

        $this->assertCount(1, $this->delivery->documents);

        $this->deleteJson(route('documents.destroy', [
            $this->order->reference,
            $this->delivery->reference,
            $this->document
        ]))->assertStatus(401);

        $this->assertCount(1, $this->delivery->documents);
    }

    /** @test */
    function users_cannot_delete_documents_they_do_not_own()
    {
        $this->withExceptionHandling();

        $johndoesCompany = factory(Company::class)->create([
            'name' => 'John Doe\'s company'
        ]);

        $johndoe = factory(User::class)->create([
            'username' => 'John Doe',
            'company_id' => $johndoesCompany->id
        ]);
        $janedoe = factory(User::class)->create([
            'username' => 'Jane Doe'
        ]);

        $business = factory(Business::class)->create([
            'name' => 'John Doe\'s business',
            'company_id' => $johndoesCompany->id
        ]);
        $order = factory(Order::class)->create([
            'reference' => 'John Doe\'s order',
            'business_id' => $business->id
        ]);
        $delivery = factory(Delivery::class)->create([
            'reference' => 'John Doe\'s delivery',
            'order_id' => $order->id
        ]);
        $document = factory(Document::class)->create([
            'delivery_id' => $delivery->id
        ]);

        $this->assertCount(1, $delivery->documents);

        $this->actingAs($janedoe);

        $this->deleteJson(route('documents.destroy', [
            $order->reference,
            $delivery->reference,
            $document
        ]))->assertStatus(403);

        $this->assertCount(1, $this->delivery->documents);
    }
}
