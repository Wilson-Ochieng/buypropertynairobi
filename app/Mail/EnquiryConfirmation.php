<?php
namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for your enquiry — Nanchong Group',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-confirmation',
        );
    }
}