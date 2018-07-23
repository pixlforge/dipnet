<?php

namespace Tests\Feature\Format;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Format;

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

    /** @test */
    public function admins_can_fetch_formats_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Format::class, 25)->create();

        $formats = $this->getJson(route('api.formats.index'));
        $this->assertCount(25, $formats->getData()->data);
    }

    /** @test */
    public function users_cannot_fetch_formats_via_the_api()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->getJson(route('api.formats.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_fetch_formats_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->getJson(route('api.formats.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_fetch_formats_via_the_api_sorted_by_name()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Format::class)->create(['name' => 'A2']);
        factory(Format::class)->create(['name' => 'A5']);
        factory(Format::class)->create(['name' => 'A1']);
        factory(Format::class)->create(['name' => 'A4']);
        factory(Format::class)->create(['name' => 'A3']);

        $response = $this->getJson(route('api.formats.index', 'name'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'A1',
            'A2',
            'A3',
            'A4',
            'A5',
        ]);
    }

    /** @test */
    public function admins_can_fetch_formats_via_the_api_sorted_by_height()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Format::class)->create(['height' => 500]);
        factory(Format::class)->create(['height' => 400]);
        factory(Format::class)->create(['height' => 300]);
        factory(Format::class)->create(['height' => 200]);
        factory(Format::class)->create(['height' => 100]);

        $response = $this->getJson(route('api.formats.index', 'height'));
        $response->assertOk();
        $response->assertSeeInOrder([
            500,
            400,
            300,
            200,
            100,
        ]);
    }

    /** @test */
    public function admins_can_fetch_formats_via_the_api_sorted_by_width()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Format::class)->create(['width' => 500]);
        factory(Format::class)->create(['width' => 400]);
        factory(Format::class)->create(['width' => 300]);
        factory(Format::class)->create(['width' => 200]);
        factory(Format::class)->create(['width' => 100]);

        $response = $this->getJson(route('api.formats.index', 'width'));
        $response->assertOk();
        $response->assertSeeInOrder([
            500,
            400,
            300,
            200,
            100,
        ]);
    }

    /** @test */
    public function admins_can_fetch_formats_via_the_api_sorted_by_creation_date()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Format::class)->create([
            'name' => 'A1',
            'created_at' => now()->addDay(),
        ]);
        factory(Format::class)->create([
            'name' => 'A2',
            'created_at' => now()->subWeek(),
        ]);
        factory(Format::class)->create([
            'name' => 'A3',
            'created_at' => now(),
        ]);
        factory(Format::class)->create([
            'name' => 'A4',
            'created_at' => now()->subMonth(),
        ]);
        factory(Format::class)->create([
            'name' => 'A5',
            'created_at' => now()->addYear(),
        ]);

        $response = $this->getJson(route('api.formats.index', 'created_at'));
        $response->assertOk();
        $response->assertSeeInOrder([
            'A5',
            'A1',
            'A3',
            'A2',
            'A4',
        ]);
    }
}
