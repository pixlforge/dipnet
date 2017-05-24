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
