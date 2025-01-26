<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GasRequestPaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token = null;
    public $price = null;
    public $outletName = null;
    public $consumerName = null;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $price, $outletName, $consumerName)
    {
        $this->token = $token;
        $this->price = $price;
        $this->outletName = $outletName;
        $this->consumerName = $consumerName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gas Request Payment Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.gas-request-payment-reminder-mail',
            with: [
                'token' => $this->token,
                'price' => $this->price,
                'outletName' => $this->outletName,
                'consumerName' => $this->consumerName]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
