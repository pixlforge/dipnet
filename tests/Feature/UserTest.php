<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Create a User for all tests to use.
     *
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();

        return $this->user = factory('App\User')->create();
    }

    /**
     * User index view is available
     *
     * @test
     */
    function user_index_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/users');

        $response->assertViewIs('users.index');
    }

    /**
     * User create view is available
     *
     * @test
     */
    function user_create_view_is_available()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/users/create');

        $response->assertViewIs('users.create');
    }

    /**
     * User edit view is available and requires a user
     *
     * @test
     */
    function user_edit_view_is_available_and_requires_a_user()
    {
        $this->signIn(null, 'administrateur');

        $response = $this->get('/users/' . $this->user->username . '/edit');

        $response->assertViewIs('users.edit');
    }

    /**
     * Authorized users can create users
     *
     * @test
     */
//    function authorized_users_can_create_users()
//    {
//        $this->signIn(null, 'administrateur');
//
//        $contact = factory('App\Contact')->create();
//
//        $company = factory('App\Company')->create();
//
//        $user = factory('App\User')->make([
//            'contact_id' => $contact->id,
//            'company_id' => $company->id
//        ]);
//
//        $this->post("/users", $user->toArray())
//            ->assertRedirect('users');
//    }


}
