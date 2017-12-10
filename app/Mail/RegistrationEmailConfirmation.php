<?php

namespace Dipnet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationEmailConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * RegistrationEmailConfirmation constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de création de compte ' . config('app.name'))
            ->markdown('emails.confirm-email');
    }
}
