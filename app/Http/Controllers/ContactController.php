<?php
namespace App\Http\Controllers;

use App\Mail\EnquiryConfirmation;
use App\Mail\EnquiryReceived;
use App\Models\ContactSubmission;
use App\Models\Partnership;
use App\Models\Project;
use App\Models\SiteContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $primary     = SiteContact::primary();
        $allContacts = SiteContact::orderBy('is_primary', 'desc')->get();

        return view('pages.contact', compact('primary', 'allContacts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:50',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:5000',
            'source'  => 'required|in:bay,island,partnership,general',
        ]);

        // 1. Save the lead first
        $submission = ContactSubmission::create($data);

        // 2. Send notification to ADMIN (routed by source)
        try {
            $recipient = $this->resolveRecipient($data['source']);
            if ($recipient) {
                Mail::to($recipient)->send(new EnquiryReceived($submission));
            } else {
                Log::warning('Enquiry admin recipient resolved to null', [
                    'submission' => $submission->id,
                    'source'     => $data['source'],
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Admin enquiry mail failed: ' . $e->getMessage(), [
                'submission' => $submission->id,
            ]);
        }

        // 3. Send confirmation to the USER
        //    Sending from the authenticated account, replyTo = user's email.
        //    (Never set `from` to the user's email — Gmail rejects that as spoofing.)
        try {
            Mail::to($data['email'])->send(
                (new EnquiryConfirmation($submission))->replyTo($data['email'], $data['name'])
            );
        } catch (\Throwable $e) {
            Log::error('User confirmation mail failed: ' . $e->getMessage(), [
                'submission' => $submission->id,
            ]);
        }

        // 4. Build the WhatsApp URL for the thank-you page
        $primary        = SiteContact::primary();
        $whatsappNumber = preg_replace('/\D/', '', $primary?->phone ?? '254710998888');
        $whatsappText   = "Hi Nanchong Group,\n\n" .
                          "I just sent an enquiry on your website.\n\n" .
                          "Name: {$data['name']}\n" .
                          "Phone: {$data['phone']}\n" .
                          "Email: {$data['email']}\n" .
                          "Source: " . ucfirst($data['source']) . "\n\n" .
                          "My message:\n{$data['message']}";

        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($whatsappText);

        // 5. Redirect
        return redirect()
            ->route('enquiry.thanks', ['ref' => $submission->id])
            ->with('success', 'Thank you — we will be in touch shortly.')
            ->with('whatsapp_url', $whatsappUrl);
    }

    private function resolveRecipient(string $source): ?string
    {
        $fallback = config('mail.leads_address')
            ?? env('LEADS_EMAIL')
            ?? 'nanchonginternational@gmail.com';

        return match ($source) {
            'bay'         => Project::where('slug', 'nanchong-longines-bay')->value('contact_email') ?: $fallback,
            'island'      => Project::where('slug', 'nanchong-longines-island')->value('contact_email') ?: $fallback,
            'partnership' => Partnership::where('is_active', true)->value('contact_email') ?: $fallback,
            default       => $fallback,
        };
    }
}