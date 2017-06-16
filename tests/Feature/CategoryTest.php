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
     * Create a Category for all tests to use.
     *
     * @return mixed
     */
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
        $this->signIn();

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
        $this->signIn();

        $response = $this->get('/categories/create');

        $response->assertViewIs('categories.create');
    }

    /**
     * Category edit view is available
     *
     * @test
     */
    function category_edit_view_is_available()
    {
        $this->signIn();

        $response = $this->get('/categories/' . $this->category->id . '/edit');

        $response->assertViewIs('categories.edit');
    }

    /**
     * Authorized users can create categories
     *
     * @test
     */
    function authorized_users_can_create_categories()
    {
        $this->signIn();

        $category = factory('App\Category')->make();

        $this->post('/categories', $category->toArray())
            ->assertRedirect('/categories');
    }

    /**
     * Authorized users can update categories
     *
     * @test
     */
    function authorized_users_can_update_categories()
    {
        $this->signIn();

        $category = factory('App\Category')->create();

        $categoryUpdated = [
            'name' => 'SuperCool'
        ];

        $this->put("/categories/{$category->id}", $categoryUpdated)
            ->assertRedirect('/categories');
    }

    /**
     * Authorized users can delete a category
     *
     * @test
     */
    function authorized_users_can_delete_a_category()
    {
        $this->signIn();

        $category = factory('App\Category')->create();

        $this->delete("/categories/{$category->id}")
            ->assertRedirect('categories');
    }
}
