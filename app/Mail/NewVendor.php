<?php

namespace App\Mail;

use App\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVendor extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendors.welcome');
    }
}
