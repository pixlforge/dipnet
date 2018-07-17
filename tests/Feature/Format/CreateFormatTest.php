<?php

namespace Tests\Feature\Format;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Format;

class CreateFormatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_new_formats()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertSuccessful();
        $this->assertCount(1, Format::all());
    }

    /** @test */
    public function users_cannot_create_new_formats()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertForbidden();
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function guests_cannot_create_new_formats()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertRedirect(route('login'));
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => '',
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 123,
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => str_repeat('a', 1),
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => str_repeat('a', 1),
            'height' => 297,
            'width' => 210,
        ]);
        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_height_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => '',
            'width' => 210,
        ]);
        $response->assertJsonValidationErrors('height');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_height_is_not_a_number()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => 'Aa',
            'width' => 210,
        ]);
        $response->assertJsonValidationErrors('height');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_width_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => '',
        ]);
        $response->assertJsonValidationErrors('width');
        $this->assertCount(0, Format::all());
    }

    /** @test */
    public function new_format_creating_validation_fails_if_width_is_not_a_number()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $this->assertCount(0, Format::all());

        $response = $this->postJson(route('admin.formats.store'), [
            'name' => 'A4',
            'height' => 297,
            'width' => 'Aa',
        ]);
        $response->assertJsonValidationErrors('width');
        $this->assertCount(0, Format::all());
    }
}
