<?php

namespace Tests\Unit\Order;

use App\User;
use App\Order;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function confirmed_users_can_access_the_order_creation_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create(['business_id' => 1]);
        $business = factory(Business::class)->create(['company_id' => $company->id]);

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Order::all());
        
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('orders.create.end', 'ODJEGDNM'));
        $this->assertCount(1, Order::all());
    }

    /** @test */
    public function solo_users_can_access_the_order_creation_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Business::class)->create([
            'user_id' => $user->id
        ]);

        $this->assertCount(0, Order::all());

        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('orders.create.end', 'ODJEGDNM'));
        $this->assertCount(1, Order::all());
    }

    /** @test */
    public function unconfirmed_users_cannot_access_the_order_creation_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'email-not-confirmed')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Order::all());
        
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('profile.index'));
        $this->assertCount(0, Order::all());
    }

    /** @test */
    public function users_without_confirmed_contact_cannot_access_the_order_creation_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'contact-not-confirmed')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Order::all());
        
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('account.contact'));
        $this->assertCount(0, Order::all());
    }

    /** @test */
    public function users_without_confirmed_company_cannot_access_the_order_creation_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user', 'company-not-confirmed')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Order::all());
        
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('account.company'));
        $this->assertCount(0, Order::all());
    }

    /** @test */
    public function users_associated_with_a_company_without_a_default_business_are_redirected_to_the_business_creation_page()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $this->assertNull($company->business_id);

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Order::all());
        
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('companies.default.business.edit'));
        $this->assertCount(0, Order::all());
    }

    /** @test */
    public function guests_cannot_access_the_order_creation_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Order::all());
        
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('login'));
        $this->assertCount(0, Order::all());
    }
}
