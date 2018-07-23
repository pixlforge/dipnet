<?php

namespace Tests\Unit\User;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_only_users()
    {
        $this->withoutExceptionHandling();

        factory(User::class, 2)->states('admin')->create();
        factory(User::class, 3)->states('user')->create();

        $this->assertCount(5, User::all());

        $users = User::onlyUsers()->get();
        $this->assertCount(3, $users);
        $this->assertEquals('utilisateur', $users[0]->role);
        $this->assertEquals('utilisateur', $users[1]->role);
        $this->assertEquals('utilisateur', $users[2]->role);
    }
}
