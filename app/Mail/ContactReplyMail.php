<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactReplyMail extends Mailable implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contact $contact, public string $replyBody)
    {
    }

    public function envelope(): Envelope
    {
        $subject = trim((string) ($this->contact->subject ?? ''));

        return new Envelope(
            subject: $subject !== '' ? "Re: {$subject}" : 'Re: Your message',
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.contact-reply',
            with: [
                'name' => (string) $this->contact->name,
                'subjectLine' => (string) ($this->contact->subject ?: 'General Inquiry'),
                'replyBody' => (string) $this->replyBody,
                'signature' => (string) config('mail.from.name', config('app.name')),
            ],
        );
    }
}