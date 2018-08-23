<?php

namespace Tests\Feature\Format;

use App\User;
use App\Format;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowFormatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_format_show_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $format = factory(Format::class)->create();

        $response = $this->get(route('admin.formats.show', $format));

        $response->assertOk();
        $response->assertViewIs('admin.formats.show');
    }
}
