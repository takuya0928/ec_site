<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;

    /**
     * Create a new message instance.
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('【MyShop】ご注文ありがとうございます')
                    ->view('emails.order_completed');
    }
}