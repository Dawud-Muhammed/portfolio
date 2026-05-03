<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contact $contact)
    {
    }

    public function envelope(): Envelope
    {
        $subject = trim((string) ($this->contact->subject ?? ''));

        return new Envelope(
            from: new Address('contact@dawud-muhammed.me', 'Portfolio System'),
        subject: 'New Contact Message Received',
            replyTo: [new Address((string) $this->contact->email)],
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message',
            with: [
                'name' => (string) $this->contact->name,
                'email' => (string) $this->contact->email,
                'subjectLine' => (string) ($this->contact->subject ?: 'General Inquiry'),
                'messageBody' => (string) $this->contact->message,
            ],
        );

    }
}