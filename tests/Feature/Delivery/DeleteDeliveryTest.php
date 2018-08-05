<?php

namespace Tests\Feature\Delivery;

use App\User;
use App\Order;
use App\Company;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDeliveryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_soft_delete_their_own_deliveries()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->deleted_at);
        
        $response = $this->deleteJson(route('deliveries.destroy', $delivery));

        $response->assertSuccessful();
        $this->assertNotNull($delivery->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_soft_delete_others_deliveries()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $otherCompany->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->deleted_at);
        
        $response = $this->deleteJson(route('deliveries.destroy', $delivery));

        $response->assertForbidden();
        $this->assertNull($delivery->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_soft_delete_deliveries()
    {
        $this->withExceptionHandling();

        $this->assertGuest();
        
        $company = factory(Company::class)->create();
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->deleted_at);
        
        $response = $this->deleteJson(route('deliveries.destroy', $delivery));

        $response->assertStatus(401);
        $this->assertNull($delivery->fresh()->deleted_at);
    }
}
