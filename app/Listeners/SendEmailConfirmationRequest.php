<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\RegistrationEmailConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailConfirmationRequest implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::to($event->user)
            ->queue(new RegistrationEmailConfirmation($event->user));
    }
}
