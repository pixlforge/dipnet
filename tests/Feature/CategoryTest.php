<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function category_index_view_is_available()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $this->get(route('categories.index'))
            ->assertStatus(200);
    }

    /** @test */
    function authorized_users_can_create_categories()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $category = factory(Category::class)->make();

        $this->postJson(route('categories.store'), $category->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
    }

    /** @test */
    function authorized_users_can_update_categories()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $category = factory(Category::class)->create();

        $category = Category::whereName($category->name)->first();

        $this->putJson(route('categories.update', $category), [
            'name' => 'Super cool name'
        ])->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'name' => 'Super cool name'
        ]);
    }

    /** @test */
    function authorized_users_can_delete_a_category()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);

        $category = factory(Category::class)->create();

        $category = Category::whereName($category->name)->first();

        $this->assertNull($category->deleted_at);

        $this->deleteJson(route('categories.destroy', $category))
            ->assertStatus(204);

        $this->assertNotNull($category->fresh()->deleted_at);
    }
}
