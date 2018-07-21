<?php

namespace Tests\Feature\Contact;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contact;

class DeleteContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_delete_existing_contacts()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);

        $contact = factory(Contact::class)->create();
        $this->assertNull($contact->deleted_at);

        $response = $this->deleteJson(route('admin.contacts.destroy', $contact));
        $response->assertSuccessful();
        $this->assertNotNull($contact->fresh()->deleted_at);
    }

    /** @test */
    public function users_cannot_delete_existing_contacts()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->states('user')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $contact = factory(Contact::class)->create();
        $this->assertNull($contact->deleted_at);

        $response = $this->deleteJson(route('admin.contacts.destroy', $contact));
        $response->assertForbidden();
        $this->assertNull($contact->fresh()->deleted_at);
    }

    /** @test */
    public function guests_cannot_delete_existing_contacts()
    {
        $this->withExceptionHandling();

        $this->assertGuest();

        $contact = factory(Contact::class)->create();
        $this->assertNull($contact->deleted_at);

        $response = $this->deleteJson(route('admin.contacts.destroy', $contact));
        $response->assertRedirect(route('login'));
        $this->assertNull($contact->fresh()->deleted_at);
    }
}
