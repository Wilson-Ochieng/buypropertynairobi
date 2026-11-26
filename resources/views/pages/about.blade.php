@extends('layouts.app')
@section('title', 'About — Buy Property Nairobi')
@section('meta_description', 'Buy Property Nairobi — property specialists helping you buy, rent and invest in premium homes and new developments in Kilimani, Kileleshwa, Westlands and Karen.')

@section('content')

    @php
        // Everything on this page is static: no $group, $heroImage or setting_image() needed.

        $facts = [
            'Office' => 'Nairobi, Kenya',
            'Focus' => 'Sales · Rentals · Investments',
            'Areas' => 'Kilimani, Kileleshwa, Westlands, Karen',
        ];

        $story = [
            'Buy Property Nairobi is a team of property specialists helping buyers, tenants and investors find premium homes and new developments across Nairobi, including Kilimani, Kileleshwa, Westlands and Karen.',
            'We cover property sales, rentals and investments, and we guide every client from the first conversation to the day they get the keys. Our approach is simple: honest advice, clear information and local expertise you can trust.',
            'Whether you are buying your first home, looking for the right rental or building an investment portfolio, we are here to help you make confident decisions and secure a brighter future.',
        ];

        $services = [
            ['Property Sales', 'Premium homes, apartments and plots for buyers across Nairobi’s sought-after neighbourhoods.'],
            ['Rentals', 'Carefully vetted rental properties for professionals, families and corporate tenants.'],
            ['New Developments', 'Early access to quality off-plan and under-construction projects.'],
            ['Investment Advice', 'Market insights and guidance to help you choose properties that hold their value.'],
            ['Viewings & Support', 'Scheduled viewings and hands-on help from first enquiry to handover.'],
        ];

        $areas = ['Kilimani', 'Kileleshwa', 'Westlands', 'Karen'];

        $values = [
            ['I', 'Integrity', 'Honest advice, transparent pricing', 'We tell clients what we would want to hear ourselves: the real condition of a property, the real numbers and the real timelines. No pressure, no surprises.'],
            ['II', 'Local Expertise', 'Rooted in Nairobi', 'We know the neighbourhoods, the roads, the amenities and the market trends. That knowledge helps you compare areas and choose with confidence.'],
            ['III', 'Client First', 'Your goals set the brief', 'Whether you are buying your first home, renting for a new job or building an investment portfolio, we start with what you need and work back from there.'],
            ['IV', 'Quality', 'Premium properties only', 'We list properties we are proud to put our name to, and we stay with you through viewings, paperwork and handover so the experience matches the standard of the home.'],
        ];

        $goldGradient = 'background-image: linear-gradient(115deg, #b47c2f, #dda950);';
    @endphp

    {{-- ==================== HERO ==================== --}}
    <section class="relative isolate overflow-hidden bg-emerald-dark text-cream">
        {{-- Optional static photo: drop a file at public/images/about-hero.jpg. If it is missing, the image removes itself
        and the gradient shows. --}}
        <img src="{{ asset('images/about-hero.jpg') }}" alt="" aria-hidden="true" fetchpriority="high"
            onerror="this.remove()" class="absolute inset-0 -z-20 h-full w-full object-cover">

        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-emerald-dark/95 via-emerald-dark/70 to-emerald-dark/30"
            aria-hidden="true"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-emerald-dark/60 via-transparent to-transparent"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -left-24 -top-24 -z-10 h-72 w-72 rounded-full bg-gold/15 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 right-0 -z-10 h-80 w-80 rounded-full bg-gold-dark/20 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-40">
            <div class="max-w-3xl">
                <div class="mb-5 flex items-center gap-3 text-sm font-medium uppercase tracking-widest text-gold">
                    <span class="h-px w-10 bg-gradient-to-r from-gold to-transparent" aria-hidden="true"></span>
                    About Us
                </div>
                <h1 class="mb-5 text-4xl font-serif font-semibold leading-tight text-white md:text-6xl">
                    Buy Property Nairobi
                </h1>
                <p class="max-w-2xl text-lg leading-relaxed text-cream/85 md:text-xl">
                    Premium properties. Trusted expertise. Brighter futures.
                </p>
                <div class="mt-8 h-1 w-20 rounded-full bg-gradient-to-r from-gold to-gold-dark" aria-hidden="true"></div>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-gold/60 to-transparent"
            aria-hidden="true"></div>
    </section>

    {{-- ==================== STORY ==================== --}}
    <section class="bg-gradient-to-b from-cream via-white to-cream">
        <x-section eyebrow="Our Story" title="Who We Are">
            <div class="grid items-start gap-10 lg:grid-cols-3 lg:gap-14">

                <div class="space-y-4 leading-relaxed text-muted lg:col-span-2">
                    @foreach($story as $para)
                        <p class="first:text-lg first:leading-relaxed first:text-ink">{{ $para }}</p>
                    @endforeach
                </div>

                <aside
                    class="relative h-fit overflow-hidden rounded-2xl border border-border-soft bg-gradient-to-br from-white via-cream to-white p-6 shadow-sm lg:sticky lg:top-28">
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-gold via-gold-dark to-gold"
                        aria-hidden="true"></div>
                    <div class="mb-4 text-sm font-semibold uppercase tracking-wider text-gold-dark">Key Facts</div>
                    <dl class="divide-y divide-border-soft text-sm">
                        @foreach($facts as $label => $value)
                            <div class="flex justify-between gap-3 py-3 first:pt-0 last:pb-0">
                                <dt class="text-muted">{{ $label }}</dt>
                                <dd class="text-right font-medium text-ink">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </aside>
            </div>
        </x-section>
    </section>

    {{-- ==================== SERVICES ==================== --}}
    <section class="border-y border-border-soft bg-gradient-to-b from-cream via-white to-cream">
        <x-section eyebrow="What We Do" title="Property Services, End to End">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 lg:gap-5">
                @foreach($services as $i => $service)
                    <div
                        class="group relative overflow-hidden rounded-xl border border-border-soft bg-white p-5 shadow-sm transition duration-300 hover:border-gold hover:shadow-lg motion-safe:hover:-translate-y-1">
                        <span
                            class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-gold to-gold-dark transition-transform duration-300 group-hover:scale-x-100"
                            aria-hidden="true"></span>
                        <div class="mb-3 bg-gradient-to-br from-gold to-gold-dark bg-clip-text text-3xl font-semibold text-transparent"
                            aria-hidden="true">
                            {{ sprintf('%02d', $i + 1) }}
                        </div>
                        <div class="mb-2 text-base font-semibold text-ink transition-colors group-hover:text-gold-dark">
                            {{ $service[0] }}
                        </div>
                        <div class="text-sm leading-relaxed text-muted">{{ $service[1] }}</div>
                    </div>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- ==================== AREAS ==================== --}}
    <section class="bg-white">
        <x-section eyebrow="Where We Work" title="Nairobi’s Most Sought-After Neighbourhoods"
            subtitle="From leafy suburbs to vibrant urban addresses, browse listings in the areas buyers and tenants ask about most.">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($areas as $area)
                    <a href="{{ route('properties.index', ['location' => $area]) }}"
                        class="group flex items-center justify-between rounded-xl border border-border-soft bg-cream px-5 py-4 transition hover:border-gold hover:bg-white hover:shadow-md">
                        <span class="font-semibold text-ink group-hover:text-gold-dark">{{ $area }}</span>
                        <span class="text-gold-dark transition group-hover:translate-x-1" aria-hidden="true">→</span>
                    </a>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- ==================== VALUES ==================== --}}
    <section class="bg-cream">
        <x-section eyebrow="Our Values" title="How We Work"
            subtitle="Four principles that guide how we advise clients, present properties and build long-term relationships.">

            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center mb-14">
                <div class="order-1">
                    <div class="aspect-[4/3] rounded-lg overflow-hidden bg-emerald-dark/10 shadow-lg">
                        <img src="{{ asset('images/about/values-circle.png') }}" alt="Buy Property Nairobi — our values"
                            onerror="this.remove()" class="w-full h-full object-cover" loading="lazy">
                    </div>
                </div>
                <div class="order-2">
                    <h3 class="text-2xl font-serif font-semibold text-ink mb-4">Advice You Can Rely On</h3>
                    <p class="text-muted leading-relaxed">
                        Property is one of the biggest decisions most people make. We combine clear information, local
                        knowledge and a calm, professional process so you can move forward with confidence, whether you are
                        buying, renting or investing.
                    </p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($values as $value)
                    <div class="bg-white border border-border-soft rounded-lg p-6 md:p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-md text-white font-bold flex items-center justify-center text-lg shrink-0"
                                style="{{ $goldGradient }}">
                                {{ $value[0] }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-ink">{{ $value[1] }}</h3>
                                <p class="text-xs uppercase tracking-wider text-gold-dark font-medium">{{ $value[2] }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-muted leading-relaxed">{{ $value[3] }}</p>
                    </div>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- ==================== CTA ==================== --}}
    <section class="relative isolate overflow-hidden bg-emerald-dark text-cream">
        <div class="pointer-events-none absolute -left-24 top-0 -z-10 h-72 w-72 rounded-full bg-gold/15 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 -z-10 h-72 w-72 rounded-full bg-gold-dark/20 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
            <div class="mx-auto mb-6 h-px w-24 bg-gradient-to-r from-transparent via-gold to-transparent"
                aria-hidden="true"></div>
            <h2 class="mb-4 text-3xl font-serif font-semibold md:text-4xl lg:text-5xl">
                <span class="text-cream">Premium properties.</span>
                <span class="bg-gradient-to-r from-gold to-white bg-clip-text text-transparent">Brighter futures.</span>
            </h2>
            <p class="mx-auto mb-10 max-w-2xl leading-relaxed text-cream/80">
                Browse our latest listings or talk to our team about your next move.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('properties.index') }}"
                    class="inline-flex items-center justify-center rounded-md px-6 py-3 font-bold text-sm text-white shadow-lg transition hover:brightness-110"
                    style="{{ $goldGradient }}">
                    Explore Properties →
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center rounded-md border border-cream/50 px-6 py-3 text-sm font-semibold text-cream transition hover:border-gold hover:text-gold focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                    Book a Viewing
                </a>
            </div>
        </div>
    </section>

@endsection