<?php

namespace Tests\Feature\Delivery;

use App\User;
use App\Order;
use App\Company;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeliveryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_can_add_new_deliveries_to_an_existing_order()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $this->assertCount(0, Delivery::all());
        
        $response = $this->postJson(route('deliveries.store', $order));
        $response->assertOk();
        $this->assertCount(1, Delivery::all());
        $this->assertEquals(1, $order->fresh()->deliveries->count());
    }

    /** @test */
    public function solo_users_can_add_new_deliveries_to_an_existing_order()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['user_id' => $user->id]);
        $this->assertCount(0, Delivery::all());
        
        $response = $this->postJson(route('deliveries.store', $order));
        $response->assertOk();
        $this->assertCount(1, Delivery::all());
        $this->assertEquals(1, $order->fresh()->deliveries->count());
    }

    /** @test */
    public function users_associated_with_a_company_cannot_add_new_deliveries_to_orders_they_do_not_own()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $otherCompany->id]);
        $this->assertCount(0, Delivery::all());
        
        $response = $this->postJson(route('deliveries.store', $order));
        $response->assertForbidden();
        $this->assertCount(0, Delivery::all());
        $this->assertEquals(0, $order->fresh()->deliveries->count());
    }

    /** @test */
    public function solo_users_cannot_add_new_deliveries_to_orders_they_do_not_own()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $otherUser = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['user_id' => $otherUser->id]);
        $this->assertCount(0, Delivery::all());
        
        $response = $this->postJson(route('deliveries.store', $order));
        $response->assertForbidden();
        $this->assertCount(0, Delivery::all());
        $this->assertEquals(0, $order->fresh()->deliveries->count());
    }

    /** @test */
    public function guests_cannot_add_new_deliveries_to_existing_orders()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $order = factory(Order::class)->create();

        $this->assertCount(0, Delivery::all());
        
        $response = $this->postJson(route('deliveries.store', $order));
        $response->assertStatus(401);
        $this->assertCount(0, Delivery::all());
    }
}
