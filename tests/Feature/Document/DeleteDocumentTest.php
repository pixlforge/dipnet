<?php

namespace Tests\Feature\Document;

use App\User;
use App\Order;
use App\Company;
use App\Document;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDocumentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_delete_their_own_documents_when_the_associated_order_is_incomplete()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);

        $this->assertCount(1, $order->documents);
        
        $response = $this->deleteJson(route('documents.destroy', $document));
        
        $response->assertSuccessful();
        $this->assertCount(0, $order->fresh()->documents);
    }

    /** @test */
    public function users_cannot_delete_their_own_documents_when_the_associated_order_status_is_not_incomplete()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create([
            'status' => 'traitée',
            'company_id' => $company->id
        ]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);

        $this->assertCount(1, $order->documents);
        
        $response = $this->deleteJson(route('documents.destroy', $document));
        
        $response->assertForbidden();
        $this->assertCount(1, $order->fresh()->documents);
    }

    /** @test */
    public function users_cannot_delete_others_documents()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);

        $this->assertCount(1, $order->documents);
        
        $response = $this->deleteJson(route('documents.destroy', $document));
        
        $response->assertForbidden();
        $this->assertCount(1, $order->fresh()->documents);
    }

    /** @test */
    public function guests_cannot_delete_documents()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);

        $this->assertCount(1, $order->documents);
        
        $response = $this->deleteJson(route('documents.destroy', $document));
        
        $response->assertStatus(401);
        $this->assertCount(1, $order->fresh()->documents);
    }
}
