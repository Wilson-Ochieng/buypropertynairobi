@extends('layouts.app')

@section('title', 'Testimonials — Nanchong Group')
@section('meta_description', 'What our clients say about buying homes from Nanchong Group in Kenya and China.')

@section('content')

    {{-- Breadcrumb --}}
    <div class="border-b border-stone-line bg-gradient-to-r from-cream via-white to-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-charcoal-soft" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-camel">Home</a>
                <svg class="h-3 w-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-charcoal" aria-current="page">Testimonials</span>
            </nav>
        </div>
    </div>

    <section class="bg-gradient-to-b from-cream via-white to-cream">
        <x-section eyebrow="Client Stories" title="Testimonials"
            subtitle="Real feedback from the people who call a Nanchong home their own.">

            {{-- ==================== STATS BAND ==================== --}}
            <div class="mb-14 grid grid-cols-2 gap-4 md:grid-cols-4 lg:gap-6">

                {{-- Highlight: average rating --}}
                <div
                    class="relative overflow-hidden rounded-xl bg-gradient-to-br from-charcoal via-charcoal-soft to-charcoal p-5 text-center text-cream shadow-md">
                    <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-camel/25 blur-2xl"
                        aria-hidden="true"></div>
                    <div class="bg-gradient-to-r from-camel to-white bg-clip-text text-4xl font-bold text-transparent">
                        {{ $stats['average'] }}
                    </div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-silver-2">Average rating</div>
                    <div class="mt-1 text-lg text-camel" role="img"
                        aria-label="{{ (int) round($stats['average']) }} out of 5 stars">
                        {{ str_repeat('★', (int) round($stats['average'])) }}
                    </div>
                </div>

                <div
                    class="relative overflow-hidden rounded-xl border border-stone-line bg-gradient-to-br from-white to-cream p-5 text-center shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-transparent via-camel to-transparent"
                        aria-hidden="true"></div>
                    <div class="text-3xl font-bold text-charcoal">{{ $stats['total'] }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-camel">Total reviews</div>
                </div>

                <div
                    class="relative overflow-hidden rounded-xl border border-stone-line bg-gradient-to-br from-white to-cream p-5 text-center shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-transparent via-camel to-transparent"
                        aria-hidden="true"></div>
                    <div class="text-3xl font-bold text-charcoal">{{ $stats['five_star'] }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-camel">5-star reviews</div>
                </div>

                <div
                    class="flex flex-col justify-center rounded-xl border border-stone-line bg-gradient-to-br from-white to-cream p-5 text-center shadow-sm">
                    <a href="{{ $stats['google_url'] }}" target="_blank" rel="noopener noreferrer"
                        class="group text-sm font-semibold text-camel transition hover:text-dusty-taupe focus:outline-none focus-visible:ring-2 focus-visible:ring-camel">
                        View on Google
                        <span class="inline-block transition-transform motion-safe:group-hover:translate-x-1"
                            aria-hidden="true">→</span>
                    </a>
                </div>
            </div>

            {{-- ==================== FEATURED TESTIMONIALS ==================== --}}
            @if($featured->isNotEmpty())
                <div class="mb-14 grid gap-6 md:grid-cols-2 lg:gap-8">
                    @foreach($featured as $t)
                        <figure
                            class="group relative flex flex-col overflow-hidden rounded-2xl border border-stone-line bg-gradient-to-br from-white via-white to-cream p-8 shadow-sm transition duration-300 hover:shadow-lg motion-safe:hover:-translate-y-1">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-camel via-dusty-taupe to-camel"
                                aria-hidden="true"></div>

                            <svg class="absolute right-6 top-6 h-12 w-12 text-camel/15" fill="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>

                            <div class="mb-3 text-xl text-camel" role="img"
                                aria-label="Rated {{ mb_substr_count($t->stars, '★') }} out of 5">{{ $t->stars }}</div>

                            <blockquote class="mb-6 flex-1 text-lg leading-relaxed text-charcoal-soft">
                                “{{ $t->quote }}”
                            </blockquote>

                            <figcaption class="flex items-center gap-3 border-t border-stone-line pt-5">
                                @if($t->author_photo || $t->google_profile_photo_url)
                                    <img src="{{ $t->author_photo ? asset('storage/' . $t->author_photo) : $t->google_profile_photo_url }}"
                                        alt="{{ $t->author_name }}" loading="lazy" referrerpolicy="no-referrer"
                                        class="h-12 w-12 rounded-full object-cover ring-2 ring-camel/40 ring-offset-2 ring-offset-white">
                                @else
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-camel to-dusty-taupe font-bold text-white ring-2 ring-camel/40 ring-offset-2 ring-offset-white">
                                        {{ strtoupper(substr($t->author_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-charcoal">{{ $t->author_name }}</div>
                                    @if($t->author_role)
                                        <div class="text-xs text-charcoal-soft">{{ $t->author_role }}</div>
                                    @endif
                                </div>
                                @if($t->source === 'google')
                                    <div class="ml-auto flex items-center gap-1 text-xs text-charcoal-soft">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                                fill="#4285F4" />
                                            <path
                                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                                fill="#34A853" />
                                            <path
                                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                                fill="#FBBC05" />
                                            <path
                                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                                fill="#EA4335" />
                                        </svg>
                                        Google
                                    </div>
                                @endif
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif

            {{-- ==================== MANUAL TESTIMONIALS ==================== --}}
            @if($manual->isNotEmpty())
                <div class="mb-14">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-charcoal">What our clients say</h2>
                        <div class="mt-2 h-0.5 w-12 rounded-full bg-gradient-to-r from-camel to-dusty-taupe" aria-hidden="true">
                        </div>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($manual as $t)
                            <figure
                                class="group relative flex flex-col overflow-hidden rounded-xl border border-stone-line bg-white p-6 shadow-sm transition duration-300 hover:border-camel hover:shadow-md motion-safe:hover:-translate-y-0.5">
                                <span
                                    class="absolute inset-x-0 top-0 h-0.5 origin-left scale-x-0 bg-gradient-to-r from-camel to-dusty-taupe transition-transform duration-300 group-hover:scale-x-100"
                                    aria-hidden="true"></span>
                                <div class="mb-3 text-lg text-camel" role="img"
                                    aria-label="Rated {{ mb_substr_count($t->stars, '★') }} out of 5">{{ $t->stars }}</div>
                                <blockquote class="mb-4 flex-1 text-sm leading-relaxed text-charcoal-soft">
                                    “{{ Str::limit($t->quote, 200) }}”
                                </blockquote>
                                <figcaption class="flex items-center gap-3 border-t border-stone-line pt-4">
                                    @if($t->author_photo)
                                        <img src="{{ asset('storage/' . $t->author_photo) }}" alt="{{ $t->author_name }}" loading="lazy"
                                            class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-camel to-dusty-taupe text-sm font-bold text-white">
                                            {{ strtoupper(substr($t->author_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-semibold text-charcoal">{{ $t->author_name }}</div>
                                        @if($t->author_role)
                                            <div class="text-xs text-charcoal-soft">{{ $t->author_role }}</div>
                                        @endif
                                    </div>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ==================== GOOGLE REVIEWS (compact grid) ==================== --}}
            @if($google->isNotEmpty())
                <div>
                    <div class="mb-6">
                        <h2 class="flex items-center gap-2 text-xl font-semibold text-charcoal">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            Google Reviews
                        </h2>
                        <div class="mt-2 h-0.5 w-12 rounded-full bg-gradient-to-r from-camel to-dusty-taupe" aria-hidden="true">
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($google as $t)
                            <figure
                                class="rounded-xl border border-stone-line bg-gradient-to-br from-cream/70 to-white p-5 transition duration-300 hover:shadow-sm">
                                <figcaption class="mb-2 flex items-center gap-2">
                                    @if($t->google_profile_photo_url)
                                        <img src="{{ $t->google_profile_photo_url }}" alt="{{ $t->author_name }}" loading="lazy"
                                            referrerpolicy="no-referrer" class="h-8 w-8 rounded-full object-cover">
                                    @endif
                                    <div class="text-sm font-semibold text-charcoal">{{ $t->author_name }}</div>
                                </figcaption>
                                <div class="mb-2 text-sm text-camel" role="img"
                                    aria-label="Rated {{ mb_substr_count($t->stars, '★') }} out of 5">{{ $t->stars }}</div>
                                <blockquote class="text-xs leading-relaxed text-charcoal-soft">
                                    “{{ Str::limit($t->quote, 140) }}”
                                </blockquote>
                                @if($t->google_review_time)
                                    <div class="mt-2 text-[11px] text-charcoal-soft/60">
                                        {{ $t->google_review_time->diffForHumans() }}
                                    </div>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Fallback if empty --}}
            @if($featured->isEmpty() && $manual->isEmpty() && $google->isEmpty())
                <div
                    class="rounded-2xl border border-stone-line bg-gradient-to-br from-white to-cream p-10 text-center text-charcoal-soft">
                    Testimonials are being collected. Check back soon.
                </div>
            @endif

        </x-section>
    </section>

    {{-- ==================== CTA ==================== --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-br from-charcoal via-charcoal-soft to-charcoal text-cream">
        <div class="pointer-events-none absolute -left-24 top-0 -z-10 h-72 w-72 rounded-full bg-camel/20 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 -z-10 h-72 w-72 rounded-full bg-dusty-taupe/25 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20 text-center">
            <div class="mx-auto mb-6 h-px w-24 bg-gradient-to-r from-transparent via-camel to-transparent"
                aria-hidden="true"></div>
            <h2 class="mb-4 text-3xl font-semibold md:text-4xl">
                <span class="text-cream">Ready to find</span>
                <span class="bg-gradient-to-r from-camel to-white bg-clip-text text-transparent">your Nanchong home?</span>
            </h2>
            <p class="mx-auto mb-8 max-w-2xl leading-relaxed text-silver-2">
                Explore our developments or speak with our team. We would love to hear from you.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('projects.index') }}" class="btn-primary">Explore our projects</a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center rounded-md border border-silver-2 px-5 py-2.5 text-silver-2 transition hover:bg-silver-2 hover:text-charcoal focus:outline-none focus-visible:ring-2 focus-visible:ring-camel">
                    Contact us
                </a>
            </div>
        </div>
    </section>

@endsection