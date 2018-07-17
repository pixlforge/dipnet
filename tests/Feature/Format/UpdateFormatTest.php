<?php

namespace Tests\Feature\Format;

use App\User;
use App\Format;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateFormatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_existing_formats()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertSuccessful();
        
        $format = Format::find($format->id);
        $this->assertEquals('A5', $format->name);
        $this->assertEquals(210, $format->height);
        $this->assertEquals(148, $format->width);
    }

    /** @test */
    public function users_cannot_update_existing_formats()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertForbidden();
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function guests_cannot_update_existing_formats()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertRedirect(route('login'));
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_name_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => '',
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertJsonValidationErrors('name');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_name_is_not_a_string()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 123,
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertJsonValidationErrors('name');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_name_is_too_short()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => str_repeat('a', 1),
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertJsonValidationErrors('name');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_name_is_too_long()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => str_repeat('a', 46),
            'height' => 210,
            'width' => 148,
        ]);
        $response->assertJsonValidationErrors('name');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_height_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => '',
            'width' => 148,
        ]);
        $response->assertJsonValidationErrors('height');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_height_is_not_numeric()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => 'Aa',
            'width' => 148,
        ]);
        $response->assertJsonValidationErrors('height');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_width_is_missing()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => '',
        ]);
        $response->assertJsonValidationErrors('width');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }

    /** @test */
    public function update_format_validation_fails_if_width_is_not_numeric()
    {
        $this->withExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        $response = $this->patchJson(route('admin.formats.update', $format), [
            'name' => 'A5',
            'height' => 210,
            'width' => 'Aa',
        ]);
        $response->assertJsonValidationErrors('width');
        
        $format = Format::find($format->id);
        $this->assertEquals('A4', $format->name);
        $this->assertEquals(297, $format->height);
        $this->assertEquals(210, $format->width);
    }
}
