<?php
namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactSubmission $submission) {}

    public function envelope(): Envelope
    {
        $sourceLabels = [
            'bay'         => 'Longines Bay',
            'island'      => 'Longines Island',
            'partnership' => 'Land Partnership',
            'general'     => 'Website',
        ];
        $source = $sourceLabels[$this->submission->source] ?? 'Website';

        return new Envelope(
            subject: "[New Enquiry — {$source}] {$this->submission->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-received',
        );
    }
}