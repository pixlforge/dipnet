<?php

namespace Tests\Feature\Format;

use Dipnet\Format;
use Dipnet\User;
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
            'width' => 210,
            'surface' => 62500
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
            'surface' => 62500
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
            'width' => 210,
            'surface' => 62500
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
            'surface' => 62500
        ]);

        $format = Format::whereName('A4')->first();

        $this->putJson(route('formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => 148,
            'surface' => 31250
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A5',
            'height' => 210,
            'width' => 148,
            'surface' => 31250
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
            'width' => 210,
            'surface' => 62500
        ])->assertStatus(200);

        $this->assertDatabaseHas('formats', [
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
            'surface' => 62500
        ]);

        $format = Format::whereName('A4')->first();

        $this->assertNull($format->deleted_at);

        $this->deleteJson(route('formats.destroy', $format))
            ->assertStatus(204);

        $this->assertNotNull($format->fresh()->deleted_at);
    }
}