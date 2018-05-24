<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function confirmed_users_can_access_the_orders_index_view()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get(route('orders.index'))
            ->assertStatus(200)
            ->assertViewIs('orders.index');
    }

    /** @test */
    public function unconfirmed_users_can_access_the_orders_index_view()
    {
        $user = factory(User::class)->states('email-not-confirmed')->create();
        $this->actingAs($user);

        $this->get(route('orders.index'))
            ->assertStatus(200)
            ->assertViewIs('orders.index');
    }

    /** @test */
    public function guests_cannot_access_the_orders_index_view()
    {
        $this->withExceptionHandling();

        $this->get(route('orders.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_confirmed_user_can_create_a_new_order()
    {
        $user = factory(User::class)->create([
            'company_id' => function () {
                return factory(Company::class)->create([
                    'business_id' => function () {
                        return factory(Business::class)->create()->id;
                    }
                ])->id;
            }
        ]);
        $this->actingAs($user);

        $order = factory(Order::class)->create([
            'user_id' => $user->id
        ]);

        $this->get(route('orders.create.end', $order))
            ->assertStatus(200)
            ->assertViewIs('orders.create');
    }

    /** @test */
    public function guests_cannot_create_new_orders()
    {
        $this->withExceptionHandling();

        $this->get(route('orders.create.start'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unconfirmed_users_cannot_create_new_orders()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('email-not-confirmed')->create();
        $this->actingAs($user);

        $this->get(route('orders.create.start'))
            ->assertRedirect(route('profile.index'));
    }

    /** @test */
    public function confirmed_users_can_delete_their_orders()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => "John Doe's company"
                ])->id;
            }
        ]);
        $this->actingAs($user);

        factory(Order::class)->create([
            'reference' => "John Doe's order",
            'business_id' => function () use ($user) {
                return factory(Business::class)->create([
                    'name' => "John Doe's Business",
                    'company_id' => $user->company->id
                ])->id;
            }
        ]);

        $orders = Order::all();
        $this->assertCount(1, $orders);

        $order = Order::whereReference("John Doe's order")->first();
        $this->assertNull($order->deleted_at);

        $this->deleteJson(route('orders.destroy', $order))
            ->assertStatus(204);
        $this->assertNotNull($order->fresh()->deleted_at);
    }

    /** @test */
    public function confirmed_users_cannot_delete_orders_they_do_not_own()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => "John Doe's company"
                ])->id;
            }
        ]);

        $anotherUser = factory(User::class)->create([
            'username' => 'Another User',
            'email' => 'anotheruser@example.com',
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => "Another user's company"
                ])->id;
            }
        ]);
        $this->actingAs($anotherUser);

        factory(Order::class)->create([
            'reference' => "John Doe's order",
            'business_id' => function () use ($user) {
                return factory(Business::class)->create([
                    'name' => "John Doe's Business",
                    'company_id' => $user->company->id
                ])->id;
            }
        ]);

        $orders = Order::all();
        $this->assertCount(1, $orders);

        $order = Order::whereReference("John Doe's order")->first();
        $this->assertNull($order->deleted_at);

        $this->deleteJson(route('orders.destroy', $order))
            ->assertStatus(403);
        $this->assertNull($order->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_orders()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => "John Doe's company"
                ])->id;
            }
        ]);

        factory(Order::class)->create([
            'reference' => "John Doe's order",
            'business_id' => function () use ($user) {
                return factory(Business::class)->create([
                    'name' => "John Doe's Business",
                    'company_id' => $user->company->id
                ])->id;
            }
        ]);

        $orders = Order::all();
        $this->assertCount(1, $orders);

        $order = Order::whereReference("John Doe's order")->first();
        $this->assertNull($order->deleted_at);

        $this->deleteJson(route('orders.destroy', $order))
            ->assertStatus(401);
        $this->assertNull($order->fresh()->deleted_at);
    }

    /** @test */
    public function an_order_can_be_completed()
    {
        Mail::fake();

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $order = factory(Order::class)->create();

        $this->patchJson(route('orders.complete', $order), $order->toArray())
            ->assertStatus(200);

        $this->assertEquals('envoyée', $order->fresh()->status);
    }
}
