<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Company;

class ListOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_fetch_completed_orders_from_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $order = factory(Order::class, 5)->create(['status' => 'envoyée']);

        $orders = $this->getJson(route('api.orders.index'));
        $this->assertCount(5, $orders->getData()->data);
    }

    /** @test */
    public function admins_can_fetch_completed_orders_from_the_api_sorted_by_reference()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $orderE = factory(Order::class)->create([
            'reference' => 'EEEEEEEE',
            'status' => 'envoyée'
        ]);
        $orderB = factory(Order::class)->create([
            'reference' => 'BBBBBBBB',
            'status' => 'envoyée'
        ]);
        $orderC = factory(Order::class)->create([
            'reference' => 'CCCCCCCC',
            'status' => 'envoyée'
        ]);
        $orderA = factory(Order::class)->create([
            'reference' => 'AAAAAAAA',
            'status' => 'envoyée'
        ]);
        $orderD = factory(Order::class)->create([
            'reference' => 'DDDDDDDD',
            'status' => 'envoyée'
        ]);

        $response = $this->getJson(route('api.orders.index', 'reference'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'reference' => 'AAAAAAAA',
            'reference' => 'BBBBBBBB',
            'reference' => 'CCCCCCCC',
            'reference' => 'DDDDDDDD',
            'reference' => 'EEEEEEEE',
        ]);
    }

    /** @test */
    public function users_associated_with_a_company_can_fetch_orders_from_the_api_sorted_by_reference()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $orderE = factory(Order::class)->create([
            'reference' => 'EEEEEEEE',
            'status' => 'envoyée',
            'company_id' => $company->id
        ]);
        $orderB = factory(Order::class)->create([
            'reference' => 'BBBBBBBB',
            'status' => 'envoyée',
            'company_id' => $company->id
        ]);
        $orderC = factory(Order::class)->create([
            'reference' => 'CCCCCCCC',
            'status' => 'envoyée',
            'company_id' => $company->id
        ]);
        $orderA = factory(Order::class)->create([
            'reference' => 'AAAAAAAA',
            'status' => 'envoyée',
            'company_id' => $company->id
        ]);
        $orderD = factory(Order::class)->create([
            'reference' => 'DDDDDDDD',
            'status' => 'envoyée',
            'company_id' => $company->id
        ]);

        $response = $this->getJson(route('api.orders.index', 'reference'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'reference' => 'AAAAAAAA',
            'reference' => 'BBBBBBBB',
            'reference' => 'CCCCCCCC',
            'reference' => 'DDDDDDDD',
            'reference' => 'EEEEEEEE',
        ]);
    }
}
