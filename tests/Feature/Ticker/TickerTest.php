<?php

namespace Tests\Feature\Ticker;

use App\User;
use App\Ticker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TickerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_visit_the_ticker_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->get(route('tickers.index'))->assertStatus(200);
    }

    /** @test */
    public function admins_can_fetch_a_paginated_list_of_all_ticker_entries()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        factory(Ticker::class, 50)->create();

        $response = $this->getJson(route('api.tickers.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function admins_can_create_ticker_entries()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('tickers.store'), [
            'body' => "It's dangerous to go alone. Take this.",
            'active' => true
        ])->assertStatus(200);

        $this->assertCount(1, $tickers = Ticker::all());
    }

    /** @test */
    public function authenticated_users_cannot_create_ticker_entries()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $this->postJson(route('tickers.store'), [
            'body' => "It's dangerous to go alone. Take this.",
            'active' => true
        ])->assertStatus(403);

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function guests_cannot_create_ticker_entries()
    {
        $this->withExceptionHandling();

        $this->postJson(route('tickers.store'), [
            'body' => "It's dangerous to go alone. Take this.",
            'active' => true
        ])->assertRedirect(route('login'));

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function store_ticker_validation_fails_if_body_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $response = $this->postJson(route('tickers.store'), [
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function store_ticker_validation_fails_if_body_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $response = $this->postJson(route('tickers.store'), [
            'body' => 123,
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function store_ticker_validation_fails_if_body_is_shorter_than_5_characters()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $response = $this->postJson(route('tickers.store'), [
            'body' => str_repeat('a', 4),
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function store_ticker_validation_fails_if_body_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $response = $this->postJson(route('tickers.store'), [
            'body' => str_repeat('a', 256),
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function store_ticker_validation_fails_if_active_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $response = $this->postJson(route('tickers.store'), [
            'body' => "It's dangerous to go alone, take this."
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('active');

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function store_ticker_validation_fails_if_active_type_is_not_a_boolean()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $response = $this->postJson(route('tickers.store'), [
            'body' => "It's dangerous to go alone, take this.",
            'active' => 123
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('active');

        $this->assertCount(0, $tickers = Ticker::all());
    }

    /** @test */
    public function admins_can_update_a_ticker_entry()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $this->putJson(route('tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => true
        ])->assertStatus(200);

        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Something else', $ticker->body);
    }

    /** @test */
    public function authenticated_users_cannot_update_a_ticker_entry()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $this->putJson(route('tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => true
        ])->assertStatus(403);

        $ticker = Ticker::find($ticker->id);
        $this->assertNotEquals('Something else', $ticker->body);
    }

    /** @test */
    public function guests_cannot_update_a_ticker_entry()
    {
        $this->withExceptionHandling();

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $this->putJson(route('tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => true
        ])->assertRedirect(route('login'));

        $ticker = Ticker::find($ticker->id);
        $this->assertNotEquals('Something else', $ticker->body);
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $response = $this->putJson(route('tickers.update', $ticker), [
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_not_of_type_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $response = $this->putJson(route('tickers.update', $ticker), [
            'body' => 123,
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_shorter_than_5_characters()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $response = $this->putJson(route('tickers.update', $ticker), [
            'body' => str_repeat('a', 4),
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_longer_than_255_characters()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $response = $this->putJson(route('tickers.update', $ticker), [
            'body' => str_repeat('a', 256),
            'active' => true
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('body');
    }

    /** @test */
    public function update_ticker_validation_fails_if_active_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $response = $this->putJson(route('tickers.update', $ticker), [
            'body' => 'Something else'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('active');
    }

    /** @test */
    public function update_ticker_validation_fails_if_active_type_is_not_boolean()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create([
            'body' => 'Something'
        ]);

        $response = $this->putJson(route('tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => 123
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('active');
    }

    /** @test */
    public function admins_can_soft_delete_ticker_entries()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $ticker = factory(Ticker::class)->states('active')->create();

        $this->assertNull($ticker->deleted_at);

        $this->deleteJson(route('tickers.destroy', $ticker))
            ->assertStatus(201);

        $this->assertNotNull($ticker->fresh()->deleted_at);
    }

    /** @test */
    public function authenticated_users_cannot_soft_delete_ticker_entries()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->signIn($user);

        $ticker = factory(Ticker::class)->states('active')->create();

        $this->assertNull($ticker->deleted_at);

        $this->deleteJson(route('tickers.destroy', $ticker))
            ->assertStatus(403);

        $this->assertNull($ticker->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_soft_delete_ticker_entries()
    {
        $this->withExceptionHandling();

        $ticker = factory(Ticker::class)->states('active')->create();

        $this->assertNull($ticker->deleted_at);

        $this->deleteJson(route('tickers.destroy', $ticker))
            ->assertRedirect(route('login'));

        $this->assertNull($ticker->fresh()->deleted_at);
    }

    /** @test */
    public function storing_a_ticker_as_active_sets_every_other_ticker_to_inactive()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        factory(Ticker::class)->states('active')->create();

        $tickers = Ticker::where('active', true)->get();
        $this->assertCount(1, $tickers);

        $this->postJson(route('tickers.store'), [
            'body' => 'Something',
            'active' => true
        ])->assertStatus(200);

        $tickers = Ticker::all();
        $this->assertCount(2, $tickers);

        $tickers = Ticker::where('active', true)->get();
        $this->assertCount(1, $tickers);
    }

    /** @test */
    public function updating_a_ticker_as_active_sets_every_other_ticker_to_inactive()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $tickerOne = factory(Ticker::class)->states('active')->create([
            'body' => 'First ticker'
        ]);
        $tickerTwo = factory(Ticker::class)->create([
            'body' => 'Something'
        ]);

        $tickers = Ticker::where('active', true)->get();
        $this->assertCount(1, $tickers);

        $this->putJson(route('tickers.update', $tickerTwo->id), [
            'body' => 'Something different',
            'active' => true
        ])->assertStatus(200);

        $tickers = Ticker::where('active', true)->get();
        $this->assertCount(1, $tickers);

        $this->assertDatabaseHas('tickers', [
            'body' => 'Something different',
            'active' => true
        ]);
        $this->assertDatabaseMissing('tickers', [
            'body' => 'First ticker',
            'active' => true
        ]);
    }
}
