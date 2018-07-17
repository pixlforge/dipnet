<?php

namespace Tests\Feature\Ticker;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Ticker;

class DeleteTickerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_delete_softly_existing_tickers()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $ticker = factory(Ticker::class)->create();
        $this->assertNull($ticker->deleted_at);

        $response = $this->deleteJson(route('admin.tickers.destroy', $ticker));
        $response->assertSuccessful();
        $this->assertNotNull($ticker->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_delete_existing_tickers()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $ticker = factory(Ticker::class)->create();
        $this->assertNull($ticker->deleted_at);

        $response = $this->deleteJson(route('admin.tickers.destroy', $ticker));
        $response->assertForbidden();
        $this->assertNull($ticker->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_existing_tickers()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $ticker = factory(Ticker::class)->create();
        $this->assertNull($ticker->deleted_at);

        $response = $this->deleteJson(route('admin.tickers.destroy', $ticker));
        $response->assertRedirect(route('login'));
        $this->assertNull($ticker->fresh()->deleted_at);
    }
}
