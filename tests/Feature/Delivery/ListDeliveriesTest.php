<?php

namespace Tests\Feature\Delivery;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Delivery;
use App\Company;
use App\Order;

class ListDeliveriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_fetch_deliveries_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Delivery::class, 25)->create();

        $deliveries = $this->getJson(route('api.deliveries.index'));
        $this->assertCount(25, $deliveries->getData()->data);
    }

    /** @test */
    public function users_associated_with_a_company_can_fetch_their_own_deliveries_via_the_api()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        factory(Delivery::class, 3)->create(['order_id' => $order->id]);
        factory(Delivery::class, 2)->create();

        $this->assertCount(5, Delivery::all());

        $deliveries = $this->getJson(route('api.deliveries.index'));
        $this->assertCount(3, $deliveries->getData()->data);
    }

    /** @test */
    public function solo_users_can_fetch_their_own_deliveries_via_the_api()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['user_id' => $user->id]);
        factory(Delivery::class, 3)->create(['order_id' => $order->id]);
        factory(Delivery::class, 2)->create();

        $this->assertCount(5, Delivery::all());

        $deliveries = $this->getJson(route('api.deliveries.index'));
        $this->assertCount(3, $deliveries->getData()->data);
    }

    /** @test */
    public function guests_cannot_fetch_deliveries_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        factory(Delivery::class, 25)->create();

        $response = $this->getJson(route('api.deliveries.index'));
        $response->assertStatus(401);
    }

    /** @test */
    public function users_can_fetch_deliveries_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        factory(Delivery::class)->create([
            'reference' => 'AAAAAAAA',
            'order_id' => $order->id,
            'created_at' => now()->subMinutes(3),
        ]);
        factory(Delivery::class)->create([
            'reference' => 'BBBBBBBB',
            'order_id' => $order->id,
            'created_at' => now()->subMinutes(4),
        ]);
        factory(Delivery::class)->create([
            'reference' => 'CCCCCCCC',
            'order_id' => $order->id,
            'created_at' => now()->subMinutes(1),
        ]);
        factory(Delivery::class)->create([
            'reference' => 'DDDDDDDD',
            'order_id' => $order->id,
            'created_at' => now()->subMinutes(5),
        ]);
        factory(Delivery::class)->create([
            'reference' => 'EEEEEEEE',
            'order_id' => $order->id,
            'created_at' => now()->subMinutes(2),
        ]);

        $response = $this->getJson(route('api.deliveries.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'CCCCCCCC',
            'EEEEEEEE',
            'AAAAAAAA',
            'BBBBBBBB',
            'DDDDDDDD',
        ]);
    }

    /** @test */
    public function users_can_fetch_deliveries_via_the_api_sorted_by_reference()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        factory(Delivery::class)->create([
            'reference' => 'DDDDDDDD',
            'order_id' => $order->id,
        ]);
        factory(Delivery::class)->create([
            'reference' => 'BBBBBBBB',
            'order_id' => $order->id,
        ]);
        factory(Delivery::class)->create([
            'reference' => 'EEEEEEEE',
            'order_id' => $order->id,
        ]);
        factory(Delivery::class)->create([
            'reference' => 'CCCCCCCC',
            'order_id' => $order->id,
        ]);
        factory(Delivery::class)->create([
            'reference' => 'AAAAAAAA',
            'order_id' => $order->id,
        ]);

        $response = $this->getJson(route('api.deliveries.index', 'reference'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'AAAAAAAA',
            'BBBBBBBB',
            'CCCCCCCC',
            'DDDDDDDD',
            'EEEEEEEE',
        ]);
    }
}
