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
     * Document views are available
     *
     * @test
     */
    function document_views_are_available()
    {
        $response = $this->get('/documents');
        $response->assertViewIs('documents.index');

        $response = $this->get('/documents/create');
        $response->assertViewIs('documents.create');

        $response = $this->get('/documents/document-id');
        $response->assertViewIs('documents.show');

        $response = $this->get('/documents/document-id/edit');
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
