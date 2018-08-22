<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminOrderCompleteNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('Nouvelle commande client')
            ->markdown('emails.admin-order-notification');
    }
}
