<?php
namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application)
    {
    }

    public function envelope(): Envelope
    {
        $role = $this->application->jobListing?->title ?? 'General Application';
        return new Envelope(
            subject: "[New Application — {$role}] {$this->application->name}",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.job-application-received');
    }

    public function attachments(): array
    {
        if (!$this->application->cv_path)
            return [];

        return [
            Attachment::fromStorage('public/' . $this->application->cv_path)
                ->as($this->application->cv_original_name ?? 'CV')
                ->withMime('application/pdf'),
        ];
    }
}