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
        $response = $this->get('/documents/create');
        $response->assertViewIs('documents.create');
    }
    
    /**
     * Document show view is available and requires a document
     * 
     * @test
     */
    function document_show_view_is_available_and_requires_a_document()
    {
        $response = $this->get('/documents/' . $this->document->id);
        $response->assertViewIs('documents.show');
    }

    /**
     * Document edit view is available and requires a document
     *
     * @test
     */
    function document_edit_view_is_available_and_requires_a_document()
    {
        $response = $this->get('/documents/' . $this->document->id . '/edit');
        $response->assertViewIs('documents.edit');
    }

    /**
     * A document can be inserted into the database
     *
     * @test
     */
    function a_document_can_be_inserted_into_the_database()
    {
        $document = factory('App\Document')->create();
        $this->assertDatabaseHas('documents', ['file_name' => $document->file_name]);
    }

    /**
     * Multiple documents can be created
     *
     * @test
     */
    function multiple_documents_can_be_created()
    {
        factory('App\Document', 100)->create();
    }
}
