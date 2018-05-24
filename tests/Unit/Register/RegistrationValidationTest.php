<?php

namespace Tests\Unit\Register;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function validation_fails_if_username_is_missing()
    {
        $this->withExceptionHandling();

        $this->json('POST', route('register.store'), [
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_email_is_missing()
    {
        $this->withExceptionHandling();

        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_password_is_missing()
    {
        $this->withExceptionHandling();

        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com'
        ])->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_password_is_incorrect()
    {
        $this->withExceptionHandling();

        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'ww',
            'password_confirmation' => 'ww'
        ])->assertStatus(422);
    }

    /** @test */
    public function validation_fails_if_password_confirmation_does_not_match()
    {
        $this->withExceptionHandling();

        $this->json('POST', route('register.store'), [
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secretz'
        ])->assertStatus(422);
    }
}
