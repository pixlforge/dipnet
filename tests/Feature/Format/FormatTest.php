<?php

namespace Tests\Feature\Format;

use App\User;
use App\Format;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function format_index_view_is_available()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->get(route('formats.index'))
            ->assertStatus(200);
    }

    /** @test */
    function an_admin_can_create_formats()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 210
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A4',
            'height' => 297,
            'width' => 210
        ]);
    }

    /** @test */
    function an_admin_can_update_formats()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 210
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A4',
            'height' => 297,
            'width' => 210
        ]);

        $format = Format::whereName('A4')->first();

        $this->putJson(route('formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => 148
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A5',
            'height' => 210,
            'width' => 148
        ]);
    }

    /** @test */
    function an_admin_can_delete_formats()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->postJson(route('formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 210
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A4',
            'height' => 297,
            'width' => 210
        ]);

        $format = Format::whereName('A4')->first();

        $this->assertNull($format->deleted_at);

        $this->deleteJson(route('formats.destroy', $format))
            ->assertStatus(204);

        $this->assertNotNull($format->fresh()->deleted_at);
    }
}