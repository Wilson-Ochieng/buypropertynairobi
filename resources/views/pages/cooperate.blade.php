@extends('layouts.app')

@section('title', 'Partner With Us — Buy Property Nairobi')
@section('meta_description', 'Partner with Buy Property Nairobi through land partnerships, real estate agencies, and freelance agent opportunities. Connect with property buyers and sellers across Nairobi and Kenya.')

@section('content')

    {{-- HERO --}}
    <section class="bg-brand-gradient text-charcoal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="max-w-3xl">
                <div class="text-sm uppercase tracking-widest text-charcoal-soft mb-3">Partner With Us</div>
                <h1 class="text-4xl md:text-6xl font-semibold leading-tight mb-4">
                    Grow With Buy Property Nairobi
                </h1>
                <p class="text-lg md:text-xl text-charcoal-soft max-w-2xl mb-8">
                    Three ways to partner with Buy Property Nairobi — bring land, market properties as an agency, or join
                    our freelance agent network.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#land" class="btn-primary">Land Partnership</a>
                    <a href="#agencies" class="btn-secondary">For Agencies</a>
                    <a href="#freelancers" class="btn-secondary">For Freelancers</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============== LAND PARTNERSHIP ============== --}}
    <section id="land" class="bg-white scroll-mt-32">
        <x-section eyebrow="Land Partnership" :title="$land->title ?? 'Land Partnership'" :subtitle="$land->subtitle ?? 'Own land? Let\'s build something together.'">

            <div class="grid lg:grid-cols-3 gap-10">

                <div class="lg:col-span-2">
                    <p class="text-charcoal-soft leading-relaxed mb-6">
                        {{ $land->description ?? 'Bring your land and explore a partnership for property development, marketing, and sales.' }}
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4 mb-8">
                        @foreach([
                                ['Design & Architecture', 'Full design coordination with our in-house and partner architects.'],
                                ['Development & Construction', 'Coordinate with experienced development and construction partners.'],
                                ['Property Management', 'Explore property management support after completion and handover.'],
                                ['Sales & Marketing', 'Property promotion, buyer engagement, and sales coordination.'],
                            ] as $i => $item)
                            <div class="bg-cream border border-stone-line rounded-lg p-4">
                                <div
                                    class="w-8 h-8 rounded-md bg-camel text-charcoal font-bold flex items-center justify-center mb-3 text-sm">
                                    {{ $i + 1 }}
                                </div>
                                <h3 class="text-sm font-semibold text-charcoal mb-1">{{ $item[0] }}</h3>
                                <p class="text-xs text-charcoal-soft leading-relaxed">{{ $item[1] }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if($land && $land->contact_email)
                        <a href="mailto:{{ $land->contact_email }}" class="btn-primary">
                            {{ $land->cta_label ?? 'Speak to the Chairman\'s office' }}
                        </a>
                    @endif
                </div>

                <aside class="bg-charcoal text-cream rounded-lg p-6 h-fit">
                    <div class="text-sm uppercase tracking-widest text-camel font-semibold mb-3">Chairman's Office</div>
                    <p class="text-sm text-silver-2 mb-4">
                        All land partnership enquiries are handled directly by the Chairman's office — confidential and
                        fast.
                    </p>
                    @if($land && $land->contact_email)
                        <a href="mailto:{{ $land->contact_email }}"
                            class="inline-flex items-center gap-2 text-camel hover:text-cream transition text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $land->contact_email }}
                        </a>
                    @endif
                </aside>
            </div>
        </x-section>
    </section>

    {{-- ============== REAL ESTATE AGENCIES ============== --}}
    <section id="agencies" class="bg-ash-grey/30 scroll-mt-32">
        <x-section eyebrow="Real Estate Agencies" :title="$agency->title ?? 'Partner With Buy Property Nairobi as an Agency'" :subtitle="$agency->subtitle ?? 'Sell Buy Property Nairobi homes with premium commission.'">

            <div class="grid lg:grid-cols-3 gap-10">

                <div class="lg:col-span-2">
                    <p class="text-charcoal-soft leading-relaxed mb-6">
                        {{ $agency->description ?? 'Registered real estate agencies are invited to partner with Buy Property Nairobi.' }}
                    </p>

                    @if($agency && !empty($agency->benefits))
                        <div class="bg-white border border-stone-line rounded-lg p-6 mb-8">
                            <h3 class="text-base font-semibold text-charcoal mb-4">What you get as an agency partner</h3>
                            <ul class="grid sm:grid-cols-2 gap-3">
                                @foreach($agency->benefits as $benefit)
                                    <li class="flex items-start gap-2 text-sm text-charcoal-soft">
                                        <svg class="w-4 h-4 text-camel shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($agency && $agency->contact_email)
                        <a href="mailto:{{ $agency->contact_email }}" class="btn-primary">
                            {{ $agency->cta_label ?? 'Apply as an agency' }}
                        </a>
                    @endif
                </div>

                <aside class="bg-white border border-stone-line rounded-lg p-6 h-fit">
                    <div class="text-sm uppercase tracking-widest text-camel font-semibold mb-3">Agency Partnerships</div>
                    <p class="text-sm text-charcoal-soft mb-4">
                        Already registered and actively selling? Reach out with your company profile and current portfolio.
                    </p>
                    @if($agency && $agency->contact_email)
                        <div class="text-xs uppercase tracking-wider text-charcoal-soft/70 mb-1">Contact</div>
                        <a href="mailto:{{ $agency->contact_email }}"
                            class="text-sm font-semibold text-camel hover:text-dusty-taupe transition break-all">
                            {{ $agency->contact_email }}
                        </a>
                    @endif
                </aside>
            </div>
        </x-section>
    </section>

    {{-- ============== FREELANCE AGENTS ============== --}}
    <section id="freelancers" class="bg-white scroll-mt-32">
        <x-section eyebrow="Freelance Agents" :title="$freelancer->title ?? 'Join Our Freelance Agent Network'"
            :subtitle="$freelancer->subtitle ?? 'Earn premium commission on every successful sale.'">

            <div class="grid lg:grid-cols-3 gap-10">

                <div class="lg:col-span-2">
                    <p class="text-charcoal-soft leading-relaxed mb-6">
                        {{ $freelancer->description ?? 'Whether you\'re an independent agent or transitioning from a larger agency, Buy Property Nairobi welcomes freelance agents.' }}
                    </p>

                    @if($freelancer && !empty($freelancer->benefits))
                        <div class="bg-cream border border-stone-line rounded-lg p-6 mb-8">
                            <h3 class="text-base font-semibold text-charcoal mb-4">What you get as a freelance agent</h3>
                            <ul class="grid sm:grid-cols-2 gap-3">
                                @foreach($freelancer->benefits as $benefit)
                                    <li class="flex items-start gap-2 text-sm text-charcoal-soft">
                                        <svg class="w-4 h-4 text-camel shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($freelancer && $freelancer->contact_email)
                        <a href="mailto:{{ $freelancer->contact_email }}" class="btn-primary">
                            {{ $freelancer->cta_label ?? 'Join as a freelance agent' }}
                        </a>
                    @endif
                </div>

                <aside class="bg-camel/10 border border-camel/30 rounded-lg p-6 h-fit">
                    <div class="text-sm uppercase tracking-widest text-camel font-semibold mb-3">Freelance Network</div>
                    <p class="text-sm text-charcoal-soft mb-4">
                        No monthly targets. No exclusivity. Just premium commission on every successful sale.
                    </p>
                    @if($freelancer && $freelancer->contact_email)
                        <a href="mailto:{{ $freelancer->contact_email }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-camel hover:text-dusty-taupe transition break-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $freelancer->contact_email }}
                        </a>
                    @endif
                </aside>
            </div>
        </x-section>
    </section>

    {{-- CTA --}}
    <section class="bg-charcoal text-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
            <h2 class="text-3xl md:text-4xl font-semibold mb-4">Not sure which partnership fits you?</h2>
            <p class="text-silver-2 mb-8 max-w-2xl mx-auto">
                Reach out and our team will guide you to the right program.
            </p>
            <a href="{{ route('contact') }}" class="btn-primary">Contact us</a>
        </div>
    </section>

@endsection