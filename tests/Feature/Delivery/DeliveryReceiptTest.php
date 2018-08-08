<?php

namespace Tests\Feature\Delivery;

use App\User;
use App\Order;
use App\Business;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryReceiptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_delivery_receipt()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $business = factory(Business::class)->create();
        $order = factory(Order::class)->states('add-contact')->create(['business_id' => $business->id]);
        $delivery = factory(Delivery::class)->states('add-contact')->create(['order_id' => $order->id]);

        $response = $this->get(route('deliveries.receipts.show', $delivery));
        $response->assertOk();
        $response->assertViewIs('deliveries.receipts.show');
    }
}
