<?php

namespace Tests\Feature\Document;

use App\User;
use App\Document;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListDocumentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_fetch_documents_via_the_api()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        factory(Document::class, 25)->create();

        $documents = $this->getJson(route('api.documents.index'));
        $this->assertCount(25, $documents->getData()->data);
    }

    /** @test */
    public function users_cannot_fetch_documents_via_the_api()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        factory(Document::class, 25)->create();

        $response = $this->getJson(route('api.documents.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function guests_cannot_fetch_documents_via_the_api()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $response = $this->getJson(route('api.documents.index'));
        $response->assertRedirect(route('login'));
    }
}
