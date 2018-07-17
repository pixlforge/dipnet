<?php

namespace Tests\Feature\Ticker;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Ticker;

class UpdateTickerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_tickers()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => true,
        ]);
        $response->assertOk();
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Something else', $ticker->body);
        $this->assertEquals(true, $ticker->active);
    }

    /** @test */
    public function users_cannot_update_tickers()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => true,
        ]);
        $response->assertForbidden();
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function guests_cannot_update_tickers()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => 'Something else',
            'active' => true,
        ]);
        $response->assertRedirect(route('login'));
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => '',
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => 123,
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => str_repeat('a', 4),
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function update_ticker_validation_fails_if_body_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => str_repeat('a', 256),
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function update_ticker_validation_fails_if_active_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => str_repeat('a', 256),
            'active' => true,
        ]);
        $response->assertJsonValidationErrors('body');
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function update_ticker_validation_fails_if_active_is_not_a_boolean()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'active' => false,
        ]);

        $response = $this->patchJson(route('admin.tickers.update', $ticker), [
            'body' => str_repeat('a', 256),
            'active' => 'true',
        ]);
        $response->assertJsonValidationErrors('body');
        
        $ticker = Ticker::find($ticker->id);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $ticker->body);
        $this->assertEquals(false, $ticker->active);
    }

    /** @test */
    public function updating_a_ticker_as_active_sets_every_other_ticker_to_inactive()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $tickerOne = factory(Ticker::class)->states('active')->create([
            'body' => 'First ticker'
        ]);
        $tickerTwo = factory(Ticker::class)->create([
            'body' => 'Something'
        ]);

        $this->assertCount(1, Ticker::where('active', true)->get());

        $response = $this->patchJson(route('admin.tickers.update', $tickerTwo->id), [
            'body' => 'Something different',
            'active' => true
        ]);
        $response->assertOk();
        $this->assertCount(1, Ticker::where('active', true)->get());

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
