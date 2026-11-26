@extends('layouts.app')

@section('title', 'Buy Property Nairobi — Premium Properties & New Developments')

@section('meta_description', 'Explore premium property for sale and rent in Nairobi — Kilimani, Kileleshwa, Westlands and Karen. Buy Property Nairobi — your property specialists.')

@section('content')

    @php
        // Neighbourhood tiles come from the locations your admin data already has ($homeLocations).
        $areas = collect($homeLocations ?? [])->filter()->unique()->take(6)->values();
    @endphp

    {{-- ==================== 1. HERO SLIDER ==================== --}}
    <x-hero-slider :slides="$slides" />

    {{-- ==================== 2. SEARCH BAR ==================== --}}
    <div class="relative z-10 mx-auto -mt-12 max-w-6xl px-4 sm:px-6 lg:px-8">
        <form action="{{ route('projects.index') }}" method="GET"
            class="overflow-hidden rounded-2xl border border-border-soft bg-white shadow-2xl">

            {{-- Buy / Rent toggle --}}
            <div class="flex items-center justify-between border-b border-border-soft bg-cream/60 px-5 py-3">
                <div class="inline-flex rounded-full bg-white p-1 shadow-inner ring-1 ring-border-soft">
                    <label class="cursor-pointer">
                        <input type="radio" name="purpose" value="buy" class="peer sr-only" checked>
                        <span class="block rounded-full px-5 py-1.5 text-sm font-semibold text-muted transition peer-checked:bg-emerald-dark peer-checked:text-cream">Buy</span>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="purpose" value="rent" class="peer sr-only">
                        <span class="block rounded-full px-5 py-1.5 text-sm font-semibold text-muted transition peer-checked:bg-emerald-dark peer-checked:text-cream">Rent</span>
                    </label>
                </div>
                <span class="hidden text-xs uppercase tracking-[0.25em] text-gold-dark sm:block">Find your property</span>
            </div>

            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-muted">Location</label>
                    <select name="location" class="w-full rounded-lg border-border-soft text-sm focus:border-gold focus:ring-gold">
                        <option value="">All Nairobi Areas</option>
                        @foreach($homeLocations as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-muted">Max Price (KES)</label>
                    <input type="number" name="max_price" min="0" placeholder="e.g. 25000000"
                        class="w-full rounded-lg border-border-soft text-sm focus:border-gold focus:ring-gold">
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-muted">Bedrooms</label>
                    <select name="bedrooms" class="w-full rounded-lg border-border-soft text-sm focus:border-gold focus:ring-gold">
                        <option value="">Any</option>
                        @foreach([1, 2, 3, 4] as $n)
                            <option value="{{ $n }}">{{ $n }}+</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">Search Properties</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== 3. TRUST STRIP ==================== --}}
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-border-soft bg-border-soft md:grid-cols-5">
            @foreach([
                ['◇', 'Verified Listings', 'Checked before publication'],
                ['⌖', 'Prime Locations', 'Kilimani, Westlands & more'],
                ['♢', 'Expert Guidance', 'From viewing to ownership'],
                ['▥', 'Investment Opportunities', 'Long-term value focus'],
                ['♧', 'Personalised Service', 'Tailored to your needs'],
            ] as $item)
                <div class="flex items-center gap-3 bg-white px-4 py-5">
                    <span class="text-2xl text-gold">{{ $item[0] }}</span>
                    <div>
                        <div class="text-sm font-semibold text-ink">{{ $item[1] }}</div>
                        <div class="text-xs text-muted">{{ $item[2] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ==================== 4. FEATURED PROPERTIES ($featuredProjects) ==================== --}}
    <x-section eyebrow="Featured Listings" title="Properties in Nairobi"
        subtitle="Explore premium apartments, villas, and investment properties across Nairobi's most desirable neighbourhoods.">

        @if($featuredProjects->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                @foreach($featuredProjects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-dashed border-border-soft bg-cream/50 px-6 py-16 text-center">
                <p class="font-serif text-xl text-ink">New listings are coming soon</p>
                <p class="mt-2 text-sm text-muted">Speak to our team and we will share what is available right now.</p>
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('projects.index', ['purpose' => 'buy']) }}" class="btn-secondary">
                View All Properties →
            </a>
        </div>
    </x-section>

    {{-- ==================== 5. EXPLORE LOCATIONS (from $homeLocations) ==================== --}}
    @if($areas->isNotEmpty())
        <section class="border-y border-border-soft bg-cream-warm">
            <x-section eyebrow="Explore Nairobi" title="Prime Neighbourhoods"
                subtitle="Find properties in Nairobi's most sought-after residential areas.">

                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
                    @foreach($areas as $area)
                        <a href="{{ route('category-pages.show', ['purpose' => 'buy', 'slug' => \Illuminate\Support\Str::slug($area), 'by' => 'location']) }}"
                            class="group relative isolate flex h-40 items-end overflow-hidden rounded-xl bg-gradient-to-br from-emerald-dark to-emerald shadow-sm transition duration-300 hover:shadow-xl motion-safe:hover:-translate-y-1">
                            <div class="pointer-events-none absolute -right-8 -top-8 -z-10 h-28 w-28 rounded-full bg-gold/15 blur-2xl transition group-hover:bg-gold/30" aria-hidden="true"></div>
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            <span class="absolute inset-x-4 top-0 h-px bg-gradient-to-r from-transparent via-gold/70 to-transparent" aria-hidden="true"></span>
                            <span class="p-4 text-cream">
                                <span class="block font-serif text-lg transition group-hover:text-gold">{{ $area }}</span>
                                <span class="mt-1 block text-xs text-cream/75">Explore →</span>
                            </span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('projects.index', ['purpose' => 'buy']) }}" class="btn-secondary">
                        View All Locations →
                    </a>
                </div>
            </x-section>
        </section>
    @endif

    {{-- ==================== 6. WHY CHOOSE BPN ==================== --}}
    <section class="relative isolate overflow-hidden bg-emerald text-cream">
        <div class="pointer-events-none absolute -left-24 -top-24 -z-10 h-72 w-72 rounded-full bg-gold/10 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 -z-10 h-72 w-72 rounded-full bg-gold-dark/15 blur-3xl" aria-hidden="true"></div>

        <x-section eyebrow="Why Buy Property Nairobi" title="Your Trusted Property Partner"
            subtitle="Local expertise. Personalised service. Premium property marketing.">

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['◇', 'Local Expertise', 'Deep knowledge of Nairobi neighbourhoods, pricing, and trends.'],
                    ['♢', 'Exclusive Listings', 'Access to premium properties and off-plan opportunities.'],
                    ['♧', 'End-to-End Support', 'From first viewing through to legal completion.'],
                    ['✦', 'Trusted Guidance', 'Verified information on every property in our portfolio.'],
                ] as $item)
                    <div class="group rounded-xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm transition duration-300 hover:border-gold/50 hover:bg-white/10">
                        <span class="text-3xl text-gold">{{ $item[0] }}</span>
                        <h3 class="mb-2 mt-4 font-serif text-lg font-semibold text-cream">{{ $item[1] }}</h3>
                        <p class="text-sm leading-relaxed text-cream/75">{{ $item[2] }}</p>
                    </div>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- ==================== 7. NEW DEVELOPMENTS ($offPlanProjects) ==================== --}}
    @if($offPlanProjects->isNotEmpty())
        <x-section eyebrow="Off-Plan Opportunities" title="New Developments"
            subtitle="Secure early pricing on upcoming residential projects.">

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                @foreach($offPlanProjects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('projects.index', ['purpose' => 'buy', 'status' => 'off_plan']) }}" class="btn-secondary">
                    View All Developments →
                </a>
            </div>
        </x-section>
    @endif

    {{-- ==================== 8. INSIGHTS TEASER ($homeInsights) ==================== --}}
    @if($homeInsights->count())
        <section class="border-y border-border-soft bg-cream-warm">
            <x-section eyebrow="Guides & Market Notes" title="Property Insights"
                subtitle="Practical guides and market analysis for Nairobi buyers and investors.">

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($homeInsights as $insight)
                        <a href="{{ route('insights.show', $insight) }}"
                            class="card group flex flex-col p-6 transition duration-300 hover:shadow-lg motion-safe:hover:-translate-y-1">
                            <div class="mb-2 text-xs font-medium uppercase tracking-widest text-gold-dark">
                                {{ $insight->location }}
                            </div>
                            <div class="mb-2 font-serif text-lg font-semibold text-ink transition group-hover:text-gold-dark">
                                {{ $insight->title }}
                            </div>
                            @if($insight->summary)
                                <div class="text-sm leading-relaxed text-muted">
                                    {{ \Illuminate\Support\Str::limit($insight->summary, 120) }}
                                </div>
                            @endif
                            <span class="mt-auto pt-4 text-sm font-medium text-gold-dark">Read more →</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('insights.index') }}" class="btn-secondary">View All Insights →</a>
                </div>
            </x-section>
        </section>
    @endif

    {{-- ==================== 9. CTA ==================== --}}
    <section class="relative isolate overflow-hidden bg-emerald-dark text-cream">
        <div class="pointer-events-none absolute -left-24 top-0 -z-10 h-72 w-72 rounded-full bg-gold/15 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 -z-10 h-72 w-72 rounded-full bg-gold-dark/20 blur-3xl" aria-hidden="true"></div>

        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 md:py-24 lg:px-8">
            <div class="mx-auto mb-6 h-px w-24 bg-gradient-to-r from-transparent via-gold to-transparent" aria-hidden="true"></div>
            <h2 class="mb-4 font-serif text-3xl text-cream md:text-4xl lg:text-5xl">Find Your Next Home in Nairobi</h2>
            <p class="mx-auto mb-10 max-w-2xl leading-relaxed text-cream/75">
                Speak to our team about your preferred area, budget, and property type. We'll help you find the right property.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="https://wa.me/254799934180?text={{ urlencode('Hi Buy Property Nairobi, please help me find a property.') }}"
                    target="_blank" rel="noopener" class="btn-primary">
                    Chat on WhatsApp →
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center rounded-md border border-gold px-5 py-3 font-bold text-gold transition hover:bg-gold hover:text-white">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection
