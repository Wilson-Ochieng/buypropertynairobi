@extends('layouts.app')

@section('title', 'Nanchong in Kenya — Nairobi Property Developer')
@section('meta_description', 'Nanchong Group in Kenya — building modern homes and mixed-use developments in Nairobi. Explore Longines Bay in Kilimani and Longines Island in Westlands.')

@section('content')

    {{-- HERO --}}
    <section class="bg-brand-gradient text-charcoal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="max-w-3xl">
                <div class="text-sm uppercase tracking-widest text-charcoal-soft mb-3">Kenya Division</div>
                <h1 class="text-4xl md:text-6xl font-semibold leading-tight mb-4">
                    Nanchong in Kenya
                </h1>
                <p class="text-lg md:text-xl text-charcoal-soft max-w-2xl mb-8">
                    {{ $page?->intro_text ?? 'Nanchong Group brings its decade-long track record of building quality homes to Kenya — landmark residential and mixed-use developments in Nairobi.' }}
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#kenya-projects" class="btn-primary">Explore our Kenya projects</a>
                    <a href="{{ route('contact') }}" class="btn-secondary">Talk to our team</a>
                </div>
            </div>
        </div>
    </section>

    {{-- PROJECTS GRID --}}
    <section id="kenya-projects" class="bg-white">
        <x-section eyebrow="Kenya Portfolio" title="Our Nairobi Projects"
            subtitle="Modern homes in two of Nairobi's most desirable neighbourhoods.">

            @if($projects->isEmpty())
                <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                    Projects are being prepared. Please check back soon.
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
            @endif
        </x-section>
    </section>

    {{-- WHY KENYA --}}
    <section class="bg-ash-grey/40">
        <x-section eyebrow="Why Invest in Nairobi" title="A Growing Market, A Trusted Developer">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                        ['Prime Locations', 'Our Kenya projects sit in Nairobi\'s most desirable residential areas — Kilimani and Westlands — with easy access to schools, malls, and the city centre.'],
                        ['International Standards', 'We bring over a decade of development experience from China. Construction quality, finishes, and amenities meet international standards.'],
                        ['Growing Demand', 'Nairobi\'s property market is one of Africa\'s strongest — with consistent demand from expats, professionals, and returning diaspora.'],
                    ] as $item)
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-charcoal mb-3">{{ $item[0] }}</h3>
                        <p class="text-sm text-charcoal-soft leading-relaxed">{{ $item[1] }}</p>
                    </div>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- FEATURED TESTIMONIALS --}}
    @if($featuredTestimonials->isNotEmpty())
        <x-section eyebrow="Client Stories" title="What Kenyans Are Saying" subtitle="Real feedback from our Kenya homeowners.">
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($featuredTestimonials as $t)
                    <div class="bg-white border border-stone-line rounded-xl p-8 relative shadow-sm">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-camel/20" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="text-amber-500 text-xl mb-3">{{ $t->stars }}</div>
                        <blockquote class="text-charcoal-soft leading-relaxed mb-6">"{{ $t->quote }}"</blockquote>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-camel text-cream font-bold flex items-center justify-center">
                                {{ strtoupper(substr($t->author_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-charcoal">{{ $t->author_name }}</div>
                                @if($t->author_role)
                                    <div class="text-xs text-charcoal-soft">{{ $t->author_role }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('testimonials') }}" class="btn-secondary">Read more testimonials</a>
            </div>
        </x-section>
    @endif

    {{-- CTA --}}
    <section class="bg-charcoal text-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
            <h2 class="text-3xl md:text-4xl font-semibold mb-4">Ready to make Nairobi your home?</h2>
            <p class="text-silver-2 mb-8 max-w-2xl mx-auto">
                Our team is ready to help you find the right property. Reach out on WhatsApp or email — we respond within
                the hour.
            </p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ route('contact') }}" class="btn-primary">Contact our Kenya team</a>
                <a href="{{ route('projects.index', ['country' => 'kenya']) }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-md border border-silver-2 text-silver-2 hover:bg-silver-2 hover:text-charcoal transition">
                    View all Kenya projects
                </a>
            </div>
        </div>
    </section>

@endsection