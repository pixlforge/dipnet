<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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

    /**
     * Multiple categories can be created
     *
     * @test
     */
    function multiple_categories_can_be_created()
    {
        factory('App\Category', 10)->create();
    }
    
    /**
     * A category can be updated
     * 
     * @test
     */
    function a_category_can_be_updated()
    {
        $category = factory('App\Category')->create();

        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
        ]);

        \App\Category::where('name', $category->name)
                    ->update(['name' => 'Cat']);

        $this->assertDatabaseHas('categories', [
            'id' => 1,
            'name' => 'Cat',
        ]);
    }

    /**
     * A category can be deleted
     *
     * @test
     */
    function a_category_can_be_deleted()
    {
        $category = factory('App\Category')->create();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id
        ]);


    }
}
