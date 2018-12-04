<?php

namespace Tests\Feature\Delivery;

use App\User;
use App\Order;
use App\Company;
use App\Contact;
use App\Delivery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->deliveryDate = today()->addDays(3)->format('Y-m-d h:i:s');
    }

    /** @test */
    public function users_associated_with_a_company_can_update_their_own_deliveries()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'to_deliver_at' => $this->deliveryDate,
        ]);
        
        $response->assertOk();

        $delivery = $delivery->fresh();
        $this->assertEquals('Lorem ipsum dolor sit amet.', $delivery->note);
        $this->assertEquals($contact->id, $delivery->contact_id);
        $this->assertEquals($this->deliveryDate, $delivery->to_deliver_at);
    }

    /** @test */
    public function users_associated_with_a_company_cannot_update_others_deliveries()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $otherCompany = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $otherCompany->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $otherCompany->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'to_deliver_at' => $this->deliveryDate,
        ]);
        
        $response->assertForbidden();

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function solo_users_can_update_their_own_deliveries()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        
        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $order = factory(Order::class)->create(['user_id' => $user->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
        $this->assertFalse($delivery->pickup);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'pickup' => true,
            'to_deliver_at' => $this->deliveryDate,
        ]);
        
        $response->assertOk();

        $delivery = $delivery->fresh();
        $this->assertEquals('Lorem ipsum dolor sit amet.', $delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertEquals($this->deliveryDate, $delivery->to_deliver_at);
        $this->assertTrue($delivery->pickup);
    }

    /** @test */
    public function solo_users_cannot_update_others_deliveries()
    {
        $this->withExceptionHandling();

        $otherUser = factory(User::class)->create();
        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        
        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $order = factory(Order::class)->create(['user_id' => $otherUser->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'to_deliver_at' => $this->deliveryDate,
        ]);
        
        $response->assertForbidden();

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function users_can_choose_to_pick_up_their_deliveries_on_site()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
        $this->assertFalse($delivery->pickup);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'to_deliver_at' => null,
            'pickup' => true
        ]);
        
        $response->assertOk();

        $delivery = $delivery->fresh();
        $this->assertEquals('Lorem ipsum dolor sit amet.', $delivery->note);
        $this->assertEquals($contact->id, $delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
        $this->assertTrue($delivery->pickup);
    }

    /** @test */
    public function delivery_update_validation_fails_if_note_is_not_a_string()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 123,
            'contact_id' => $contact->id,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('note');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function delivery_update_validation_fails_if_note_is_too_long()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => str_repeat('a', 3001),
            'contact_id' => $contact->id,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('note');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function delivery_update_validation_fails_if_contact_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => 999,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);

        $response->assertJsonValidationErrors('contact_id');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function delivery_update_validation_fails_if_date_is_invalid()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'to_deliver_at' => 'invalid-date',
        ]);
    
        $response->assertJsonValidationErrors('to_deliver_at');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function delivery_update_validation_fails_if_date_is_not_set_to_tomorrow_at_least()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'contact_id' => $contact->id,
            'to_deliver_at' => today(),
        ]);
    
        $response->assertJsonValidationErrors('to_deliver_at');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admins_can_update_deliveries()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'admin_note' => 'Lorem ipsum.',
            'contact_id' => $contact->id,
            'to_deliver_at' => $this->deliveryDate,
        ]);
        
        $response->assertOk();

        $delivery = $delivery->fresh();
        $this->assertEquals('Lorem ipsum dolor sit amet.', $delivery->note);
        $this->assertEquals('Lorem ipsum.', $delivery->admin_note);
        $this->assertEquals($contact->id, $delivery->contact_id);
        $this->assertEquals($this->deliveryDate, $delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_note_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 123,
            'admin_note' => 'Lorem ipsum.',
            'contact_id' => $contact->id,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('note');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_note_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => str_repeat('a', 3001),
            'admin_note' => 'Lorem ipsum.',
            'contact_id' => $contact->id,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('note');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_admin_note_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'admin_note' => 123,
            'contact_id' => $contact->id,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('admin_note');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_admin_note_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'admin_note' => str_repeat('a', 3001),
            'contact_id' => $contact->id,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('admin_note');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_contact_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'admin_note' => 'Lorem ipsum.',
            'contact_id' => 999,
            'to_deliver_at' => '2018-12-01 08:00:00',
        ]);
        
        $response->assertJsonValidationErrors('contact_id');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_to_deliver_at_date_is_invalid()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'admin_note' => 'Lorem ipsum.',
            'contact_id' => $contact->id,
            'to_deliver_at' => 'something-wrong',
        ]);
        
        $response->assertJsonValidationErrors('to_deliver_at');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }

    /** @test */
    public function admin_delivery_update_validation_fails_if_to_deliver_at_date_is_not_set_to_tomorrow_at_least()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $order = factory(Order::class)->create();
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);

        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);

        $response = $this->patchJson(route('admin.deliveries.update', $delivery), [
            'note' => 'Lorem ipsum dolor sit amet.',
            'admin_note' => 'Lorem ipsum.',
            'contact_id' => $contact->id,
            'to_deliver_at' => today(),
        ]);
        
        $response->assertJsonValidationErrors('to_deliver_at');

        $delivery = $delivery->fresh();
        $this->assertNull($delivery->note);
        $this->assertNull($delivery->admin_note);
        $this->assertNull($delivery->contact_id);
        $this->assertNull($delivery->to_deliver_at);
    }
}
