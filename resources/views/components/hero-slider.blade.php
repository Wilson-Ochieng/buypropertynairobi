@props(['slides'])

@php
    $goldGradient = 'background-image: linear-gradient(115deg, #b47c2f, #dda950);';
@endphp

@if($slides->isEmpty())
    {{-- Fallback hero when no slides have been added in the admin --}}
    <section class="relative isolate overflow-hidden bg-emerald-dark text-cream">
        <div class="pointer-events-none absolute -left-24 -top-24 -z-10 h-72 w-72 rounded-full bg-gold/15 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 -z-10 h-72 w-72 rounded-full bg-gold-dark/20 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="max-w-3xl">
                <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-gold mb-4">
                    Nairobi, Kenya
                </p>
                <h1 class="text-4xl md:text-6xl font-serif font-semibold leading-tight mb-4">
                    Buy Property Nairobi
                </h1>
                <p class="text-lg md:text-xl text-cream/80 mb-8">
                    Premium properties. Trusted expertise. Brighter futures.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('properties.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-md font-bold text-sm text-white shadow-lg transition hover:brightness-110"
                        style="{{ $goldGradient }}">
                        Browse Properties →
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold text-sm text-cream border border-cream/40 hover:border-gold hover:text-gold transition">
                        Book a Viewing
                    </a>
                </div>
            </div>
        </div>
    </section>
@else
    <section x-data="{
            current: 0,
            count: {{ $slides->count() }},
            paused: false,
            timer: null,
            init() {
                const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (this.count > 1 && !reduced) {
                    this.timer = setInterval(() => {
                        if (!this.paused && !document.hidden) this.next();
                    }, 8000);
                }
            },
            destroy() { clearInterval(this.timer) },
            goTo(i) { this.current = i },
            next() { this.current = (this.current + 1) % this.count },
            prev() { this.current = (this.current - 1 + this.count) % this.count }
        }"
        @mouseenter="paused = true" @mouseleave="paused = false"
        @focusin="paused = true" @focusout="paused = false"
        @keydown.arrow-left.window="prev()" @keydown.arrow-right.window="next()"
        class="relative bg-emerald-dark overflow-hidden"
        aria-roledescription="carousel" aria-label="Featured properties">

        {{-- The header is sticky (in normal flow), so the hero does not need extra top padding. --}}
        <div class="relative h-[70vh] min-h-[480px] md:h-[80vh] md:min-h-[560px]">
            @foreach($slides as $i => $slide)
                @php $alt = $slide->title ?: 'Buy Property Nairobi'; @endphp
                <div x-show="current === {{ $i }}" x-cloak
                    x-transition:enter="transition-opacity duration-700"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-700"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="absolute inset-0 isolate" role="group" aria-roledescription="slide"
                    aria-label="{{ $i + 1 }} of {{ $slides->count() }}">

                    {{-- BACKGROUND LAYER --}}
                    @if($slide->type === 'image')
                        @if($slide->image_path)
                            <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $alt }}"
                                class="absolute inset-0 w-full h-full object-cover"
                                style="filter: brightness(1.18) saturate(1.12) contrast(1.04);"
                                loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                                @if($i === 0) fetchpriority="high" @endif>
                        @else
                            <div class="absolute inset-0 bg-emerald-dark"></div>
                        @endif
                    @elseif(in_array($slide->type, ['youtube', 'vimeo']) && $slide->video_id)
                        {{-- Poster shows until the video loads; iframe only mounts while its slide is active --}}
                        @if($slide->poster_path)
                            <img src="{{ asset('storage/' . $slide->poster_path) }}" alt="{{ $alt }}"
                                class="absolute inset-0 w-full h-full object-cover -z-10"
                                style="filter: brightness(1.18) saturate(1.12);">
                        @endif
                        <div class="absolute inset-0 overflow-hidden">
                            <template x-if="current === {{ $i }}">
                                @if($slide->type === 'youtube')
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $slide->video_id }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $slide->video_id }}&modestbranding=1&rel=0&playsinline=1"
                                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[177.78vh] h-[56.25vw] min-w-full min-h-full pointer-events-none"
                                        frameborder="0" allow="autoplay; encrypted-media" title="{{ $alt }}"></iframe>
                                @else
                                    <iframe
                                        src="https://player.vimeo.com/video/{{ $slide->video_id }}?autoplay=1&muted=1&loop=1&background=1&controls=0&autopause=0"
                                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[177.78vh] h-[56.25vw] min-w-full min-h-full pointer-events-none"
                                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                        title="{{ $alt }}"></iframe>
                                @endif
                            </template>
                        </div>
                    @else
                        <div class="absolute inset-0 bg-emerald-dark"></div>
                    @endif

                    {{-- OVERLAY: light touch so photos stay bright; a soft left-side shade keeps the text readable --}}
                    <div class="absolute inset-0 pointer-events-none"
                        style="background-image:
                            linear-gradient(to right, rgba(4,47,36,0.55) 0%, rgba(4,47,36,0.18) 45%, rgba(4,47,36,0) 70%),
                            linear-gradient(to bottom, rgba(4,47,36,0.30) 0%, rgba(4,47,36,0) 25%, rgba(4,47,36,0) 65%, rgba(4,47,36,0.35) 100%);">
                    </div>
                    <div class="absolute inset-x-0 bottom-0 h-px pointer-events-none bg-gradient-to-r from-transparent via-gold/70 to-transparent"
                        aria-hidden="true"></div>

                    {{-- CONTENT --}}
                    <div class="relative h-full flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-10">
                            <div class="max-w-2xl">
                                <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-gold mb-4"
                                    style="text-shadow: 0 1px 6px rgba(0,0,0,0.5);">
                                    Buy Property Nairobi
                                </p>
                                @if($slide->title)
                                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-serif font-semibold leading-snug mb-4 text-white"
                                        style="text-shadow: 0 2px 12px rgba(0,0,0,0.55);">
                                        {{ $slide->title }}
                                    </h1>
                                @endif
                                @if($slide->subtitle)
                                    <p class="text-sm md:text-base font-light tracking-wide text-white/85 max-w-md mb-8 pl-4 border-l-2 border-gold leading-relaxed"
                                        style="text-shadow: 0 1px 6px rgba(0,0,0,0.5);">
                                        {{ $slide->subtitle }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap gap-3">
                                    @if($slide->cta_label && $slide->cta_url)
                                        <a href="{{ $slide->cta_url }}"
                                            class="inline-flex items-center justify-center px-6 py-3 rounded-md font-bold text-sm text-white shadow-lg transition hover:brightness-110"
                                            style="{{ $goldGradient }}">
                                            {{ $slide->cta_label }}
                                        </a>
                                    @endif
                                    <a href="{{ route('contact') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold text-sm text-white border border-white/50 hover:border-gold hover:text-gold transition backdrop-blur-sm">
                                        Book a Viewing
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CONTROLS --}}
        @if($slides->count() > 1)
            <button type="button" @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-emerald-dark/50 backdrop-blur-sm border border-white/30 text-white hover:bg-gold/80 hover:border-gold transition flex items-center justify-center"
                aria-label="Previous slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button" @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-emerald-dark/50 backdrop-blur-sm border border-white/30 text-white hover:bg-gold/80 hover:border-gold transition flex items-center justify-center"
                aria-label="Next slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                @foreach($slides as $i => $slide)
                    <button type="button" @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300"
                        :class="current === {{ $i }} ? 'w-8 bg-gold' : 'w-2 bg-white/40 hover:bg-white/70'"
                        aria-label="Go to slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </section>
@endif
