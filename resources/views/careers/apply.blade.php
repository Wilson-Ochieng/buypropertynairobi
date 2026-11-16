@extends('layouts.app')

@section('title', 'Apply — ' . ($selectedJob?->title ?? 'General Application') . ' — Nanchong Group')
@section('meta_description', 'Submit your application to join the Nanchong Group team.')

@section('content')

    <div class="bg-cream border-b border-stone-line">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-charcoal-soft flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-camel">Home</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('about.careers') }}" class="hover:text-camel">Work With Us</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-charcoal font-medium">Apply</span>
            </nav>
        </div>
    </div>

    <x-section>
        <div class="max-w-2xl mx-auto">

            <div class="mb-8">
                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-2">Application</div>
                <h1 class="text-3xl font-semibold text-charcoal mb-2">
                    {{ $selectedJob ? 'Apply for: ' . $selectedJob->title : 'Submit Your Application' }}
                </h1>
                @if($selectedJob?->summary)
                    <p class="text-charcoal-soft">{{ $selectedJob->summary }}</p>
                @endif
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-md mb-6">
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('careers.apply.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white border border-stone-line rounded-lg p-6 md:p-8 space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Role applying for
                    </label>
                    <select name="job_listing_id"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                        <option value="">General application — no specific role</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}" @selected(old('job_listing_id', $selectedJob?->id) == $job->id)>
                                {{ $job->title }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-charcoal-soft mt-1">
                        Leave as "General application" if you're submitting your CV without a specific role in mind.
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Full
                            Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Current
                            Location</label>
                        <input type="text" name="current_location" value="{{ old('current_location') }}"
                            placeholder="Nairobi, Kenya"
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">LinkedIn URL
                        (optional)</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}"
                        placeholder="https://linkedin.com/in/..."
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Cover Letter</label>
                    <textarea name="cover_letter" rows="6" required placeholder="Tell us why you're a great fit…"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">{{ old('cover_letter') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Upload CV (PDF or DOC, max 5 MB)
                    </label>
                    <input type="file" name="cv" accept=".pdf,.doc,.docx" required
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-camel file:text-charcoal file:font-semibold">
                </div>

                <button type="submit" class="w-full btn-primary">
                    Submit Application
                </button>
            </form>

            <p class="text-xs text-charcoal-soft text-center mt-4">
                Your application will be reviewed by our HR team. We'll be in touch if there's a fit.
            </p>
        </div>
    </x-section>

@endsection