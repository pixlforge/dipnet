<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmInvalidTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function confirming_an_invalid_token()
    {
        $this->signIn();

        $this->get(route('register.confirm.index', ['token' => 'invalid']))
            ->assertRedirect(route('index'))
            ->assertSessionHas('flash');
    }
}
