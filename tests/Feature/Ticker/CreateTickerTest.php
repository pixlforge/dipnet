<?php

namespace Tests\Feature\Ticker;

use App\User;
use App\Ticker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTickerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_tickers()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => "It's dangerous to go alone. Take this.",
            'active' => true
        ]);
        $response->assertOk();

        $this->assertCount(1, Ticker::all());
    }

    /** @test */
    public function users_cannot_create_tickers()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => "It's dangerous to go alone. Take this.",
            'active' => true
        ]);
        $response->assertForbidden();

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function guests_cannot_create_tickers()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => "It's dangerous to go alone. Take this.",
            'active' => true
        ]);
        $response->assertRedirect(route('login'));

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function new_ticker_creation_validation_fails_if_body_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => '',
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function new_ticker_creation_validation_fails_if_body_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => 123,
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function new_ticker_creation_validation_fails_if_body_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => str_repeat('a', 4),
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function new_ticker_creation_validation_fails_if_body_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => str_repeat('a', 256),
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function new_ticker_creation_validation_fails_if_active_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => '',
        ]);
        $response->assertJsonValidationErrors('active');

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function new_ticker_creation_validation_fails_if_active_is_not_a_boolean()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Ticker::all());

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => 'true',
        ]);
        $response->assertJsonValidationErrors('active');

        $this->assertCount(0, Ticker::all());
    }

    /** @test */
    public function storing_a_ticker_as_active_sets_every_other_ticker_to_inactive()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Ticker::class)->states('active')->create();

        $tickers = Ticker::where('active', true)->get();
        $this->assertCount(1, $tickers);

        $response = $this->postJson(route('admin.tickers.store'), [
            'body' => 'Something',
            'active' => true
        ]);
        $response->assertOk();

        $this->assertCount(2, Ticker::all());
        $this->assertCount(1, Ticker::where('active', true)->get());
    }
}
