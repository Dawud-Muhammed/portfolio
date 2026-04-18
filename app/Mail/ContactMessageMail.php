<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactMessageMail extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * @param array<string, string> $payload
     */
    public function __construct(public array $payload)
    {
    }

    public function envelope(): Envelope
    {
        $subject = trim((string) ($this->payload['subject'] ?? ''));

        return new Envelope(
            subject: $subject !== '' ? "New Contact: {$subject}" : 'New Portfolio Contact Message',
            replyTo: [new Address($this->payload['email'])],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message',
            with: [
                'name' => $this->payload['name'],
                'email' => $this->payload['email'],
                'subjectLine' => $this->payload['subject'] ?: 'General Inquiry',
                'messageBody' => $this->payload['message'],
            ],
        );
    }
}
