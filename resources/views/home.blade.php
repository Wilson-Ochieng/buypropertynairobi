@extends('layouts.app')

@section('title', 'Buy Property Nairobi — Premium Properties & New Developments')

@section('meta_description', 'Explore premium property for sale and rent in Nairobi — Kilimani, Kileleshwa, Westlands and Karen. Buy Property Nairobi — your property specialists.')

@section('content')

    {{-- ==================== 1. HERO SLIDER ==================== --}}
    <x-hero-slider :slides="$slides ?? collect()" />
    {{-- ==================== 2. SEARCH BAR ==================== --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <form action="{{ route('projects.index') }}" method="GET"
            class="bg-white border border-border-soft rounded-lg shadow-lg p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <input type="hidden" name="purpose" value="buy">

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-muted mb-1">Location</label>
                <select name="location" class="w-full border-border-soft rounded text-sm focus:ring-gold focus:border-gold">
                    <option value="">All Nairobi Areas</option>
                    @foreach($homeLocations ?? [] as $loc)
                        <option value="{{ $loc }}">{{ $loc }}</option>
                    @endforeach
                    <option value="Kileleshwa">Kileleshwa</option>
                    <option value="Kilimani">Kilimani</option>
                    <option value="Westlands">Westlands</option>
                    <option value="Karen">Karen</option>
                    <option value="Lavington">Lavington</option>
                    <option value="Riverside">Riverside</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-muted mb-1">Type</label>
                <select name="type" class="w-full border-border-soft rounded text-sm focus:ring-gold focus:border-gold">
                    <option value="">All Types</option>
                    <option value="Apartment">Apartment</option>
                    <option value="Villa">Villa</option>
                    <option value="Townhouse">Townhouse</option>
                    <option value="Penthouse">Penthouse</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-muted mb-1">Max Price (KES)</label>
                <input type="number" name="max_price" placeholder="e.g. 10,000,000"
                    class="w-full border-border-soft rounded text-sm focus:ring-gold focus:border-gold">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-muted mb-1">Bedrooms</label>
                <select name="bedrooms" class="w-full border-border-soft rounded text-sm focus:ring-gold focus:border-gold">
                    <option value="">Any</option>
                    <option value="1">1+</option>
                    <option value="2">2+</option>
                    <option value="3">3+</option>
                    <option value="4">4+</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">Search Properties</button>
            </div>
        </form>
    </div>

    {{-- ==================== 3. TRUST STRIP ==================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 border-y border-border-soft">
            @foreach([
                    ['◇', 'Verified Listings', 'Checked before publication'],
                    ['⌖', 'Prime Locations', 'Kilimani, Westlands & more'],
                    ['♢', 'Expert Guidance', 'From viewing to ownership'],
                    ['▥', 'Investment Opportunities', 'Long-term value focus'],
                    ['♧', 'Personalised Service', 'Tailored to your needs'],
                ] as $item)
                <div class="flex items-center gap-3 py-4 px-3 border-r border-border-soft last:border-r-0">
                    <span class="text-2xl text-gold">{{ $item[0] }}</span>
                    <div>
                        <div class="text-sm font-semibold text-ink">{{ $item[1] }}</div>
                        <div class="text-xs text-muted">{{ $item[2] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ==================== 4. FEATURED PROPERTIES ==================== --}}
    <x-section eyebrow="Featured Listings" title="Properties in Nairobi"
        subtitle="Explore premium apartments, villas, and investment properties across Nairobi's most desirable neighbourhoods.">

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($featuredProjects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('projects.index', ['purpose' => 'buy']) }}" class="btn-secondary">
                View All Properties →
            </a>
        </div>
    </x-section>

    {{-- ==================== 5. EXPLORE LOCATIONS ==================== --}}
    <section class="bg-cream-warm border-y border-border-soft">
        <x-section eyebrow="Explore Nairobi" title="Prime Neighbourhoods"
            subtitle="Find properties in Nairobi's most sought-after residential areas.">

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                @foreach([
                        ['Kileleshwa', 'Kileleshwa'],
                        ['Kilimani', 'Kilimani'],
                        ['Westlands', 'Westlands'],
                        ['Karen', 'Karen'],
                        ['Lavington', 'Lavington'],
                        ['Riverside', 'Riverside'],
                    ] as $area)
                    <a href="{{ route('category-pages.show', ['purpose' => 'buy', 'slug' => \Illuminate\Support\Str::slug($area[1])]) }}"
                        class="group relative h-40 rounded-lg overflow-hidden flex items-end"
                        style="background-image: linear-gradient(to top, rgba(0,53,40,0.9) 0%, transparent 60%); background-color: #004536;">
                        <span class="relative z-10 p-4 text-cream">
                            <span class="block font-serif text-lg group-hover:text-gold transition">{{ $area[0] }}</span>
                            <span class="block text-xs text-cream/70 mt-1">Explore →</span>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('projects.index', ['purpose' => 'buy']) }}" class="btn-secondary">
                    View All Locations →
                </a>
            </div>
        </x-section>
    </section>

    {{-- ==================== 6. WHY CHOOSE BPN ==================== --}}
    <section class="bg-emerald text-cream">
        <x-section eyebrow="Why Buy Property Nairobi" title="Your Trusted Property Partner"
            subtitle="Local expertise. Personalised service. Premium property marketing.">

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                        ['◇', 'Local Expertise', 'Deep knowledge of Nairobi neighbourhoods, pricing, and trends.'],
                        ['♢', 'Exclusive Listings', 'Access to premium properties and off-plan opportunities.'],
                        ['♧', 'End-to-End Support', 'From first viewing through to legal completion.'],
                        ['✦', 'Trusted Guidance', 'Verified information on every property in our portfolio.'],
                    ] as $item)
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6">
                        <span class="text-3xl text-gold">{{ $item[0] }}</span>
                        <h3 class="text-lg font-semibold text-cream mt-3 mb-2">{{ $item[1] }}</h3>
                        <p class="text-sm text-cream/75 leading-relaxed">{{ $item[2] }}</p>
                    </div>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- ==================== 7. NEW DEVELOPMENTS ==================== --}}
    @if($offPlanProjects->isNotEmpty())
        <x-section eyebrow="Off-Plan Opportunities" title="New Developments"
            subtitle="Secure early pricing on upcoming residential projects.">

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($offPlanProjects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('projects.index', ['purpose' => 'buy', 'status' => 'off_plan']) }}" class="btn-secondary">
                    View All Developments →
                </a>
            </div>
        </x-section>
    @endif

    {{-- ==================== 8. INSIGHTS TEASER ==================== --}}
    @if($homeInsights->count())
        <section class="bg-cream-warm border-y border-border-soft">
            <x-section eyebrow="Guides & Market Notes" title="Property Insights"
                subtitle="Practical guides and market analysis for Nairobi buyers and investors.">

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($homeInsights as $insight)
                        <a href="{{ route('insights.show', $insight) }}" class="card p-6 flex flex-col group">
                            <div class="text-xs font-medium uppercase tracking-widest text-gold-dark mb-2">
                                {{ $insight->location }}
                            </div>
                            <div class="text-lg font-serif font-semibold text-ink mb-2 group-hover:text-gold-dark transition">
                                {{ $insight->title }}
                            </div>
                            @if($insight->summary)
                                <div class="text-sm leading-relaxed text-muted">
                                    {{ Str::limit($insight->summary, 120) }}
                                </div>
                            @endif
                            <span class="mt-auto pt-4 text-sm font-medium text-gold-dark">
                                Read more →
                            </span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('insights.index') }}" class="btn-secondary">
                        View All Insights →
                    </a>
                </div>
            </x-section>
        </section>
    @endif

    {{-- ==================== 9. CTA ==================== --}}
    <section class="bg-emerald-dark text-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif mb-4 text-cream">
                Find Your Next Home in Nairobi
            </h2>
            <p class="mx-auto mb-10 max-w-2xl leading-relaxed text-cream/75">
                Speak to our team about your preferred area, budget, and property type. We'll help you find the right
                property.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="https://wa.me/254799934180?text={{ urlencode('Hi Buy Property Nairobi, please help me find a property.') }}"
                    target="_blank" rel="noopener" class="btn-primary">
                    Chat on WhatsApp →
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center px-5 py-3 rounded font-bold border border-gold text-gold hover:bg-gold hover:text-white transition">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection