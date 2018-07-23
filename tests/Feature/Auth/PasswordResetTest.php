<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_request_a_password_reset()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $user = factory(User::class)->states('user')->create(['email' => 'john@example.com']);
        
        $this->assertGuest();

        $this->get(route('password.request'));

        $passwordResets = DB::table('password_resets')->get();
        $this->assertCount(0, $passwordResets);
        
        $response = $this->post(route('password.email'), [
            'email' => 'john@example.com'
        ]);
        $response->assertRedirect(route('password.request'));

        $passwordResets = DB::table('password_resets')->get();
        $this->assertCount(1, $passwordResets);

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }
}
