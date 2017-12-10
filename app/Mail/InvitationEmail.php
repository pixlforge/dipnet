<?php

namespace Dipnet\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $user
     */
    public $invitation;

    /**
     * Create a new message instance.
     *
     * @param $invitation
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation à rejoindre ' . config('app.name'))
            ->markdown('emails.invitation-email');
    }
}
