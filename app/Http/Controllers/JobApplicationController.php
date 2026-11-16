<?php
namespace App\Http\Controllers;

use App\Mail\JobApplicationReceived;
use App\Models\GroupInfo;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobApplicationController extends Controller
{
    public function create(Request $request)
    {
        $jobId = $request->query('job');
        $selectedJob = $jobId ? JobListing::active()->find($jobId) : null;
        $jobs = JobListing::active()->orderBy('sort_order')->get();
        $group = GroupInfo::current();

        return view('careers.apply', compact('jobs', 'selectedJob', 'group'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_listing_id' => 'nullable|exists:job_listings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'current_location' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:500',
            'cover_letter' => 'required|string|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',  // 5 MB
        ]);

        // Save CV
        $cvPath = null;
        $cvOriginalName = null;
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $cvOriginalName = $file->getClientOriginalName();
            $cvPath = $file->store('applications/cv', 'public');
        }

        // Save application
        $application = JobApplication::create([
            'job_listing_id' => $data['job_listing_id'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'current_location' => $data['current_location'] ?? null,
            'linkedin_url' => $data['linkedin_url'] ?? null,
            'cover_letter' => $data['cover_letter'],
            'cv_path' => $cvPath,
            'cv_original_name' => $cvOriginalName,
            'status' => 'new',
        ]);

        // Determine recipient
        $recipient = null;
        $customEmail = $request->input('send_to_email');  // optional override from form

        if ($customEmail && filter_var($customEmail, FILTER_VALIDATE_EMAIL)) {
            $recipient = $customEmail;
        } elseif ($application->jobListing && $application->jobListing->contact_email) {
            $recipient = $application->jobListing->contact_email;
        } else {
            $group = GroupInfo::current();
            $recipient = $group?->careers_cta_email ?? config('mail.leads_address', 'nanchonginternational@gmail.com');
        }

        try {
            if ($recipient) {
                Mail::to($recipient)->send(new JobApplicationReceived($application));
            }

            // Also notify admin inbox (non-duplicate)
            $adminEmail = config('mail.leads_address');
            if ($adminEmail && $adminEmail !== $recipient) {
                Mail::to($adminEmail)->send(new JobApplicationReceived($application));
            }
        } catch (\Throwable $e) {
            Log::error('Job application mail failed: ' . $e->getMessage(), ['application' => $application->id]);
        }

        return redirect()->route('careers.apply.thanks');
    }

    public function thanks()
    {
        return view('careers.apply-thanks');
    }
}