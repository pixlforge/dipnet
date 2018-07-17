<?php

namespace Tests\Feature\Ticker;

use App\User;
use App\Ticker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTickersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_visit_the_ticker_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.tickers.index'));
        $response->assertOk();
        $response->assertViewIs('admin.tickers.index');
        $response->assertSee('Liste de tous les tickers');
    }

    /** @test */
    public function admins_can_fetch_a_paginated_list_of_all_tickers()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Ticker::class, 50)->create();

        $response = $this->getJson(route('api.tickers.index'));
        $response->assertJsonFragment(['total' => 50]);
        $response->assertOk();
    }
}
