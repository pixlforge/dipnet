<?php

namespace Tests\Feature\Ticker;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Ticker;

class ShowTickerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_show_ticker_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create();

        $response = $this->get(route('admin.tickers.show', $ticker));

        $response->assertOk();
        $response->assertViewIs('admin.tickers.show');
    }

    /** @test */
    public function users_cannot_access_the_show_ticker_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $ticker = factory(Ticker::class)->create();

        $response = $this->get(route('admin.tickers.show', $ticker));

        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_show_ticker_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $ticker = factory(Ticker::class)->create();

        $response = $this->get(route('admin.tickers.show', $ticker));

        $response->assertRedirect(route('login'));
    }
}
