<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerOrderCompleteConfirmation extends Mailable implements ShouldQueue
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
        $this->order->load('user', 'business', 'contact', 'deliveries.contact', 'deliveries.documents.article', 'deliveries.documents.articles', 'deliveries.documents.media');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('Confirmation de commande ' . config('app.name'))
            ->markdown('emails.customer-order-confirmation');
    }
}
