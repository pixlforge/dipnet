<?php

namespace Tests\Feature\Document;

use App\User;
use App\Order;
use App\Company;
use App\Business;
use App\Delivery;
use App\Document;
use Tests\TestCase;
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
    public function users_can_delete_documents_from_a_delivery()
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
    public function guests_cannot_delete_documents_from_existing_deliveries()
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
}
