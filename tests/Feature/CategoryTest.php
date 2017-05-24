<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A category can be inserted into the database
     *
     * @test
     */
    function a_category_can_be_inserted_into_the_database()
    {
        $category = factory('App\Category')->create();
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }
}
