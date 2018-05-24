<?php

namespace Tests\Feature\Order;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_without_a_default_business_are_redirected()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get(route('orders.create.start'))
            ->assertRedirect(route('businesses.create'));
    }

    /** @test */
    public function admins_are_not_redirected_by_the_middleware()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get(route('orders.create.start'))
            ->assertStatus(302);
    }

    /** @test */
    public function users_registered_as_solo_are_not_redirected_by_the_middleware()
    {
        $user = factory(User::class)->states('solo')->create();
        $this->actingAs($user);

        $this->get(route('orders.create.start'))
            ->assertStatus(302);
    }
}
