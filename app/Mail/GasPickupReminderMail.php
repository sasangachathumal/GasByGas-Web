<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GasPickupReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $outletName = null;
    public $pickupDate = null;
    public $consumerName = null;

    /**
     * Create a new message instance.
     */
    public function __construct($outletName, $pickupDate, $consumerName)
    {
        $this->outletName = $outletName;
        $this->pickupDate = $pickupDate;
        $this->consumerName = $consumerName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gas Pickup Reminder Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.gas-pickup-reminder-mail',
            with: [
                'outletName' => $this->outletName,
                'pickupDate' => $this->pickupDate,
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
