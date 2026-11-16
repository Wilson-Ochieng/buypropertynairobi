@extends('layouts.app')

@section('title', 'Work With Us — Nanchong Group')
@section('meta_description', 'Join Nanchong Group — careers in real estate sales, property management, construction, and marketing in Kenya and China.')

@section('content')

    {{-- HERO --}}
    <section class="bg-brand-gradient text-charcoal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="max-w-3xl">
                <div class="text-sm uppercase tracking-widest text-charcoal-soft mb-3">Work With Us</div>
                <h1 class="text-4xl md:text-6xl font-semibold leading-tight mb-4">
                    Build Your Career With Nanchong
                </h1>
                <p class="text-lg md:text-xl text-charcoal-soft max-w-2xl mb-8">
                    {{ $group->careers_intro ?? 'Nanchong Group is growing — in China and in Kenya. We\'re always looking for talented people in real estate sales, property management, construction, and marketing to join our team.' }}
                </p>
                <div class="flex flex-wrap gap-3">
                    @if(\App\Models\JobListing::active()->exists())
                        <a href="#open-positions" class="btn-primary">See open positions</a>
                    @endif
                    @if($group && $group->careers_cta_email)
                        <a href="mailto:{{ $group->careers_cta_email }}?subject=Career Enquiry" class="btn-secondary">
                            Send us your CV
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- INTRO + ADVERT IMAGE --}}
    <x-section eyebrow="About" title="Work With Us">
        <div class="grid lg:grid-cols-3 gap-10">

            {{-- Advert image (if uploaded in admin) --}}
            @if($group && $group->careers_advert_image)
                <div class="lg:col-span-2">
                    @if($group->careers_advert_url)
                        <a href="{{ $group->careers_advert_url }}"
                            target="{{ str_starts_with($group->careers_advert_url, 'http') ? '_blank' : '_self' }}"
                            rel="{{ str_starts_with($group->careers_advert_url, 'http') ? 'noopener' : '' }}" class="block group">
                            <div class="rounded-lg overflow-hidden bg-ash-grey">
                                <img src="{{ asset('storage/' . $group->careers_advert_image) }}" alt="Work with Nanchong Group"
                                    class="w-full h-auto group-hover:scale-[1.02] transition-transform duration-300">
                            </div>
                        </a>
                    @else
                        <div class="rounded-lg overflow-hidden bg-ash-grey">
                            <img src="{{ asset('storage/' . $group->careers_advert_image) }}" alt="Work with Nanchong Group"
                                class="w-full h-auto">
                        </div>
                    @endif
                </div>
            @endif

            {{-- Intro text --}}
            <div class="{{ $group && $group->careers_advert_image ? 'lg:col-span-1' : 'lg:col-span-3' }} space-y-6">
                <div class="bg-white border border-stone-line rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-charcoal mb-3">Why Join Nanchong Group</h2>
                    <div class="space-y-3 text-sm text-charcoal-soft leading-relaxed">
                        <p>
                            Nanchong Group is a growing international real estate developer operating across China and
                            Kenya. Since 2010, we've built a reputation for quality, integrity, and long-term thinking.
                        </p>
                        <p>
                            Our team of over 300 professionals works across five integrated sectors — real estate, hotels,
                            construction, property management, and landscaping.
                        </p>
                        <p>
                            We don't always have openings listed, but we welcome your CV. If you're passionate about
                            building better homes and creating communities, we'd love to hear from you.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- OPEN POSITIONS --}}
        @php
            $openJobs = \App\Models\JobListing::active()->orderBy('sort_order')->get();
        @endphp

        <div id="open-positions" class="mt-16 pt-10 border-t border-stone-line scroll-mt-32">
            <div class="mb-6">
                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-2">Open Positions</div>
                <h2 class="text-2xl font-semibold text-charcoal">Join Our Team</h2>
            </div>

            @if($openJobs->isEmpty())
                {{-- Empty state --}}
                <div class="bg-cream border border-stone-line rounded-lg p-8 md:p-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-camel/15 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-camel" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-charcoal mb-2">No open positions right now</h3>
                    <p class="text-sm text-charcoal-soft mb-6 max-w-md mx-auto">
                        We don't have any active job listings at the moment. But we're always interested in meeting talented
                        people — send us your CV and we'll keep it on file.
                    </p>
                    <div class="flex flex-wrap gap-2 justify-center">
                        <a href="{{ route('careers.apply') }}" class="btn-primary text-sm">
                            Submit a general application
                        </a>
                        @if($group && $group->careers_cta_email)
                            <a href="mailto:{{ $group->careers_cta_email }}?subject=Career Enquiry" class="btn-secondary text-sm">
                                Email us your CV
                            </a>
                        @endif
                    </div>
                </div>
            @else
                {{-- Job listings --}}
                <div class="space-y-4">
                    @foreach($openJobs as $job)
                        <div class="bg-white border border-stone-line rounded-lg p-5 hover:border-camel transition">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-charcoal mb-1">{{ $job->title }}</h3>
                                    <div class="flex flex-wrap gap-3 text-xs text-charcoal-soft mb-3">
                                        @if($job->department)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                {{ $job->department }}
                                            </span>
                                        @endif
                                        @if($job->location)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                {{ $job->location }}
                                            </span>
                                        @endif
                                        @if($job->employment_type)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $job->employment_type }}
                                            </span>
                                        @endif
                                        @if($job->expires_at)
                                            <span class="text-camel font-medium">
                                                Closes {{ $job->expires_at->format('M j, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($job->summary)
                                        <p class="text-sm text-charcoal-soft leading-relaxed">{{ $job->summary }}</p>
                                    @endif
                                </div>

                                <div class="shrink-0">
                                    <a href="{{ route('careers.apply', ['job' => $job->id]) }}"
                                        class="btn-primary text-sm whitespace-nowrap">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- SEND CV / GENERAL APPLICATION CTA --}}
        <div class="mt-12 bg-cream border border-stone-line rounded-lg p-8 md:p-10">
            <div class="max-w-3xl">
                <h2 class="text-2xl font-semibold text-charcoal mb-3">Don't see a role for you?</h2>
                <p class="text-charcoal-soft mb-6">
                    We don't always have openings listed, but we welcome your CV. Submit a general application and we'll
                    keep it on file.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('careers.apply') }}" class="btn-primary">
                        Submit a general application
                    </a>
                    @if($group && $group->careers_cta_email)
                        <a href="mailto:{{ $group->careers_cta_email }}?subject=Career Enquiry" class="btn-secondary">
                            Or email {{ $group->careers_cta_email }}
                        </a>
                    @else
                        <a href="mailto:careers@nanchonginternational.com?subject=Career Enquiry" class="btn-secondary">
                            Or email careers@nanchonginternational.com
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </x-section>

@endsection