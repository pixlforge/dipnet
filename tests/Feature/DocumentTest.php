<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a Document for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();

        return $this->document = factory('App\Document')->create();
    }

    /** @test */
    function document_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/documents');

        $response->assertViewIs('documents.index');
    }

    /** @test */
    function authorized_users_can_create_documents()
    {
        $this->signIn(null, 'administrateur');

        $document = factory('App\Document')->create();

        $this->post('/documents', $document->toArray())
            ->assertRedirect('/documents');
    }
}
