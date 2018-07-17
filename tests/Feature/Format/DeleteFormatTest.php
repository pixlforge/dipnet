<?php

namespace Tests\Feature\Format;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Format;

class DeleteFormatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_delete_softly_existing_formats()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create();
        $this->assertNull($format->delete_at);

        $response = $this->deleteJson(route('admin.formats.destroy', $format));
        $response->assertSuccessful();

        $this->assertNotNull($format->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_delete_softly_existing_formats()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $format = factory(Format::class)->create();
        $this->assertNull($format->delete_at);

        $response = $this->deleteJson(route('admin.formats.destroy', $format));
        $response->assertForbidden();

        $this->assertNull($format->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_softly_existing_formats()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $format = factory(Format::class)->create();
        $this->assertNull($format->delete_at);

        $response = $this->deleteJson(route('admin.formats.destroy', $format));
        $response->assertRedirect(route('login'));

        $this->assertNull($format->fresh()->deleted_at);
    }
}
