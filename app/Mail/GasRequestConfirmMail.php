<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GasRequestConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token = null;
    public $expiryDate = null;
    public $consumerName = null;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $expiryDate, $consumerName)
    {
        $this->token = $token;
        $this->expiryDate = $expiryDate;
        $this->consumerName = $consumerName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gas Request Confirm',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.gas-request-confirm-mail',
            with: [
                'token' => $this->token,
                'expiryDate' => $this->expiryDate,
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
