<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    function category_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $this->get('/categories')
            ->assertStatus(200);
    }

    /** @test */
    function authorized_users_can_create_categories()
    {
        $this->signIn(null, 'administrateur');

        $category = factory('App\Category')->make();

        $this->post('/categories', $category->toArray())
            ->assertRedirect('/categories');
    }

    /** @test */
    function authorized_users_can_update_categories()
    {
        $this->signIn(null, 'administrateur');

        $category = factory('App\Category')->create();

        $categoryUpdated = [
            'name' => 'SuperCool'
        ];

        $this->put("/categories/{$category->id}", $categoryUpdated)
            ->assertRedirect('/categories');
    }

    /** @test */
    function authorized_users_can_delete_a_category()
    {
        $this->signIn(null, 'administrateur');

        $category = factory('App\Category')->create();

        $this->delete("/categories/{$category->id}")
            ->assertRedirect(route('categories.index'));
    }
}
