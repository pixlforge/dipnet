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
    public function admins_can_visit_the_tickers_index_page()
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
    public function users_cannot_visit_the_tickers_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.tickers.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_visit_the_tickers_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.tickers.index'));
        $response->assertRedirect(route('login'));
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

    /** @test */
    public function admins_can_fetch_tickers_via_the_api_sorted_by_active_state()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Ticker::class)->create(['body' => 'Ticker A']);
        factory(Ticker::class)->create(['body' => 'Ticker B']);
        factory(Ticker::class)->states('active')->create(['body' => 'Ticker C']);
        factory(Ticker::class)->create(['body' => 'Ticker D']);
        factory(Ticker::class)->create(['body' => 'Ticker E']);
        
        $response = $this->getJson(route('api.tickers.index', 'active'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Ticker C',
            'Ticker A',
            'Ticker B',
            'Ticker D',
            'Ticker E',
        ]);
    }

    /** @test */
    public function admins_can_fetch_tickers_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Ticker::class)->create([
            'body' => 'Ticker A',
            'created_at' => now()->subDay(),
        ]);
        factory(Ticker::class)->create([
            'body' => 'Ticker B',
            'created_at' => now()->subWeek(),
        ]);
        factory(Ticker::class)->states('active')->create([
            'body' => 'Ticker C',
            'created_at' => now()->subMonth(),
        ]);
        factory(Ticker::class)->create([
            'body' => 'Ticker D',
            'created_at' => now()->addDay(),
        ]);
        factory(Ticker::class)->create([
            'body' => 'Ticker E',
            'created_at' => now()->addMonth(),
        ]);
        
        $response = $this->getJson(route('api.tickers.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'Ticker E',
            'Ticker D',
            'Ticker A',
            'Ticker B',
            'Ticker C',
        ]);
    }
}
