<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmInvalidTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function confirming_an_invalid_token()
    {
        $this->signIn();

        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('index'))
            ->assertSessionHas('flash');
    }
}
