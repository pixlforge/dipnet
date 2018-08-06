<?php

namespace Tests\Feature\Document;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListDocumentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_the_documents_index_page()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $response = $this->get(route('admin.documents.index'));
        $response->assertOk();
        $response->assertViewIs('admin.documents.index');
        $response->assertSee('Liste de tous les documents');
    }

    /** @test */
    public function users_cannot_access_the_documents_index_page()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get(route('admin.documents.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_access_the_documents_index_page()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->get(route('admin.documents.index'));
        $response->assertRedirect(route('login'));
    }
}
