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
     * A user can be created
     *
     * @test
     */
    public function a_user_can_be_created()
    {
        $user = factory(User::class)->create();
    }
}
