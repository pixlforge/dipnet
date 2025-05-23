<?php

namespace Tests\Unit\Register;

use App\Company;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistationCompanyValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();

        $user = factory(User::class)->states('not-confirmed')->create();
        $this->signIn($user);
    }

    /** @test */
    public function it_fails_if_name_is_too_short()
    {
        $this->json('POST', route('register.company.store'), [
            'name' => 'K'
        ])->assertStatus(422);
    }

    /** @test */
    public function it_fails_if_name_is_too_long()
    {
        // Name is 68 characters
        $this->json('POST', route('register.company.store'), [
            'name' => 'Innovator entrepreneur business plan founders funding learning curve'
        ])->assertStatus(422);
    }

    /** @test */
    public function it_fails_if_name_already_exists()
    {
        factory(Company::class)->create(['name' => 'The Night\'s Watch']);

        $this->json('POST', route('register.company.store'), [
            'name' => 'The Night\'s Watch'
        ])->assertStatus(422);
    }
}
