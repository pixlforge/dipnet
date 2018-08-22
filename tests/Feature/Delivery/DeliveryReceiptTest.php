<?php

namespace Tests\Feature\Delivery;

use App\User;
use App\Order;
use App\Business;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Company;

class DeliveryReceiptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_delivery_receipt()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $company = factory(Company::class)->create();
        $user = factory(User::class)->create(['company_id' => $company->id]);
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->states('add-contact')->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'business_id' => $business->id
        ]);
        $delivery = factory(Delivery::class)->states('add-contact')->create(['order_id' => $order->id]);

        $response = $this->get(route('deliveries.receipts.show', $delivery));
        $response->assertOk();
        $response->assertViewIs('deliveries.receipts.show');
    }
}
