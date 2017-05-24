<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A format can be inserted into the database
     *
     * @test
     */
    function a_format_can_be_inserted_into_the_database()
    {
        $format = factory('App\Format')->create();
        $this->assertDatabaseHas('formats', ['name' => $format->name]);
    }
}
