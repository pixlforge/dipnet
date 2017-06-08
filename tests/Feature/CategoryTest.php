<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        return $this->category = factory('App\Category')->create();
    }

    /**
     * Category index view is available
     *
     * @test
     */
    function category_index_view_is_available()
    {
        $response = $this->get('/categories');
        $response->assertViewIs('categories.index');
    }

    /**
     * Category create view is available
     *
     * @test
     */
    function category_create_view_is_available()
    {
        $response = $this->get('/categories/create');
        $response->assertViewIs('categories.create');
    }

    /**
     * Category show view is available
     *
     * @test
     */
    function category_show_view_is_available()
    {
        $response = $this->get('/categories/' . $this->category->name);
        $response->assertViewIs('categories.show');
    }

    /**
     * Category edit view is available
     *
     * @test
     */
    function category_edit_view_is_available()
    {
        $response = $this->get('/categories/' . $this->category->name . '/edit');
        $response->assertViewIs('categories.edit');
    }

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

        $categoryToDelete = \App\Category::find(1);
        $categoryToDelete->delete();
        $this->assertDatabaseMissing('categories', [
            'id' => $categoryToDelete->id
        ]);
    }
}
