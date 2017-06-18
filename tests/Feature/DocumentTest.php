<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentTest extends TestCase
{
    use DatabaseMigrations;

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

    /**
     * Document index view is available
     *
     * @test
     */
    function document_index_view_is_available()
    {
        $this->signIn();

        $response = $this->get('/documents');

        $response->assertViewIs('documents.index');
    }

    /**
     * Document create view is available
     *
     * @test
     */
    function document_create_view_is_available()
    {
        $this->signIn();

        $response = $this->get('/documents/create');

        $response->assertViewIs('documents.create');
    }

    /**
     * Document edit view is available and requires a document
     *
     * @test
     */
    function document_edit_view_is_available_and_requires_a_document()
    {
        $this->signIn();

        $response = $this->get('/documents/' . $this->document->id . '/edit');

        $response->assertViewIs('documents.edit');
    }

    /**
     * Authorized users can create documents
     *
     * @test
     */
    function authorized_users_can_create_documents()
    {
        $this->signIn();

        $document = factory('App\Document')->create();

        $this->post('/documents', $document->toArray())
            ->assertRedirect('/documents');
    }

}
