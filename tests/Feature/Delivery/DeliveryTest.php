<?php

namespace Tests\Feature\Delivery;

use App\User;
use App\Order;
use App\Company;
use App\Delivery;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Global setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->admin = factory(User::class)->states('admin')->create();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function an_admin_can_access_the_deliveries_index_page()
    {
        $this->actingAs($this->admin);

        $this->get(route('deliveries.index'))
            ->assertStatus(200)
            ->assertViewIs('deliveries.index');
    }

    /** @test */
    public function guests_cannot_access_the_deliveries_index_page()
    {
        $this->withExceptionHandling();

        $this->get(route('deliveries.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function users_who_are_not_admins_cannot_access_the_deliveries_index_page()
    {
        $this->withExceptionHandling();

        $this->actingAs($this->user);

        $this->get(route('deliveries.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function admins_can_create_new_deliveries()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin);

        $order = factory(Order::class)->create();

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id,
        ])->assertStatus(200);

        $deliveries = Delivery::all();
        $this->assertCount(1, $deliveries);
    }

    /** @test */
    public function users_who_are_not_admins_can_create_new_deliveries()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user);

        $order = factory(Order::class)->create();

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id,
        ])->assertStatus(200);

        $deliveries = Delivery::all();
        $this->assertCount(1, $deliveries);
    }

    /** @test */
    public function guests_cannot_create_deliveries()
    {
        $this->withExceptionHandling();

        $order = factory(Order::class)->create();

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);

        $this->postJson(route('deliveries.store'), [
            'order_id' => $order->id,
        ])->assertStatus(401);

        $deliveries = Delivery::all();
        $this->assertCount(0, $deliveries);
    }

    /** @test */
    public function admins_can_update_deliveries()
    {
        $this->actingAs($this->admin);

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'order_id' => $order->id
        ]);

        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);

        $this->putJson(route('deliveries.update', $delivery), [
            'reference' => 'abcdef',
            'note' => 'Lorem ipsum dolor sit amet.',
            'order_id' => $order->id
        ])->assertStatus(200);

        $this->assertDatabaseMissing('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);
        $this->assertDatabaseHas('deliveries', [
            'reference' => 'abcdef',
            'note' => 'Lorem ipsum dolor sit amet.',
            'order_id' => $order->id
        ]);
    }

    /** @test */
    public function guests_cannot_update_deliveries()
    {
        $this->withExceptionHandling();

        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'order_id' => $order->id
        ]);

        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);

        $this->putJson(route('deliveries.update', $delivery), [
            'reference' => 'abcdef',
            'note' => 'Lorem ipsum dolor sit amet.',
            'order_id' => $order->id
        ])->assertStatus(401);

        $this->assertDatabaseMissing('deliveries', [
            'reference' => 'abcdef',
            'note' => 'Lorem ipsum dolor sit amet.',
            'order_id' => $order->id
        ]);
        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $order->id
        ]);
    }

    /** @test */
    public function users_who_are_not_admins_can_update_their_companys_deliveries()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
           'company_id' => function () {
               return factory(Company::class)->create()->id;
           }
        ]);
        $this->actingAs($user);

        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'note' => null,
            'order_id' => function () use ($user) {
                return factory(Order::class)->create([
                    'business_id' => function () use ($user) {
                        return factory(Business::class)->create([
                            'company_id' => $user->company->id
                        ])->id;
                    }
                ])->id;
            }
        ]);

        $this->assertDatabaseHas('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $delivery->order->id
        ]);

        $this->putJson(route('deliveries.update', $delivery), [
            'reference' => 'abcdef',
            'note' => 'Lorem ipsum dolor sit amet.',
            'order_id' => $delivery->order->id
        ])->assertStatus(200);

        $this->assertDatabaseHas('deliveries', [
            'reference' => 'abcdef',
            'note' => 'Lorem ipsum dolor sit amet.',
            'order_id' => $delivery->order->id
        ]);
        $this->assertDatabaseMissing('deliveries', [
            'reference' => '123456',
            'note' => null,
            'order_id' => $delivery->order->id
        ]);
    }

    /** @test */
    public function admins_can_delete_deliveries()
    {
        $this->actingAs($this->admin);

        $delivery = factory(Delivery::class)->create();

        $this->assertNull($delivery->deleted_at);

        $this->deleteJson(route('deliveries.destroy', $delivery))
            ->assertStatus(204);

        $this->assertNotNull($delivery->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_deliveries()
    {
        $this->withExceptionHandling();

        $delivery = factory(Delivery::class)->create();

        $this->assertNull($delivery->deleted_at);

        $this->deleteJson(route('deliveries.destroy', $delivery))
            ->assertStatus(401);

        $this->assertNull($delivery->fresh()->deleted_at);
    }

    /** @test */
    public function users_who_are_not_admins_can_delete_their_companys_deliveries()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'company_id' => function () {
                return factory(Company::class)->create()->id;
            }
        ]);
        $this->actingAs($user);

        $delivery = factory(Delivery::class)->create([
            'reference' => '123456',
            'note' => null,
            'order_id' => function () use ($user) {
                return factory(Order::class)->create([
                    'business_id' => function () use ($user) {
                        return factory(Business::class)->create([
                            'company_id' => $user->company->id
                        ])->id;
                    }
                ])->id;
            }
        ]);

        $this->assertNull($delivery->deleted_at);

        $this->deleteJson(route('deliveries.destroy', $delivery))
            ->assertStatus(204);

        $this->assertNotNull($delivery->fresh()->deleted_at);
    }
}
