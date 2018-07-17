<?php

namespace Tests\Feature\Format;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListFormatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_formats_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.formats.index'));
        $response->assertSuccessful();
        $response->assertViewIs('admin.formats.index');
        $response->assertSee('Liste de tous les formats');
    }

    /** @test */
    public function users_cannot_access_the_formats_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.formats.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_formats_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.formats.index'));
        $response->assertRedirect(route('login'));
    }
}
