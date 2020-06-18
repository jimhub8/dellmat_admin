<?php

namespace App\Mail;

use App\models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $user;
    public $cart;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sale $sale, $user, $cart)
    {
        $this->sale = $sale;
        $this->user = $user;
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.order');
    }
}
