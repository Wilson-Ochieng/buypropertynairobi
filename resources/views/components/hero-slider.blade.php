@props(['slides'])

@if($slides->isEmpty())
    <section class="relative bg-brand-gradient text-charcoal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-6xl font-semibold leading-tight mb-4">
                    Nanchong Group
                </h1>
                <p class="text-lg md:text-xl text-charcoal-soft">
                    Building homes for love, quality Nanchong
                </p>
            </div>
        </div>
    </section>
@else
    <section x-data="{
                            current: 0,
                            count: {{ $slides->count() }},
                            paused: false,
                            init() {
                                if (this.count > 1) {
                                    this.timer = setInterval(() => {
                                        if (!this.paused) {
                                            this.current = (this.current + 1) % this.count;
                                        }
                                    }, 8000);
                                }
                            },
                            goTo(i) { this.current = i },
                            next() { this.current = (this.current + 1) % this.count },
                            prev() { this.current = (this.current - 1 + this.count) % this.count }
                        }" x-init="init()" @mouseenter="paused = true" @mouseleave="paused = false"
        class="relative bg-[#0f172a] overflow-hidden">

        <div class="relative h-[70vh] min-h-[480px] md:h-[85vh] md:min-h-[600px]">
            @foreach($slides as $i => $slide)
                <div x-show="current === {{ $i }}" x-transition:enter="transition-opacity duration-700"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="absolute inset-0">

                    {{-- BACKGROUND LAYER --}}
                    @if($slide->type === 'image')
                        @if($slide->image_path)
                            <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title }}"
                                class="absolute inset-0 w-full h-full object-cover"
                                style="filter: brightness(1.15) saturate(1.15) contrast(1.05);"
                                loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        @else
                            <div class="absolute inset-0 bg-brand-gradient"></div>
                        @endif
                    @elseif($slide->type === 'youtube' && $slide->video_id)
                        <div class="absolute inset-0 overflow-hidden">
                            <iframe
                                src="https://www.youtube.com/embed/{{ $slide->video_id }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $slide->video_id }}&modestbranding=1&rel=0&showinfo=0&playsinline=1"
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[177.78vh] h-[56.25vw] min-w-full min-h-full pointer-events-none"
                                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen
                                loading="{{ $i === 0 ? 'eager' : 'lazy' }}" title="{{ $slide->title }}"></iframe>
                        </div>
                    @elseif($slide->type === 'vimeo' && $slide->video_id)
                        <div class="absolute inset-0 overflow-hidden">
                            <iframe
                                src="https://player.vimeo.com/video/{{ $slide->video_id }}?autoplay=1&muted=1&loop=1&background=1&controls=0&autopause=0"
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[177.78vh] h-[56.25vw] min-w-full min-h-full pointer-events-none"
                                frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
                                loading="{{ $i === 0 ? 'eager' : 'lazy' }}" title="{{ $slide->title }}"></iframe>
                        </div>
                    @endif

                    @if(in_array($slide->type, ['youtube', 'vimeo']) && $slide->poster_path)
                        <img src="{{ asset('storage/' . $slide->poster_path) }}" alt="{{ $slide->title }}"
                            class="absolute inset-0 w-full h-full object-cover -z-10">
                    @endif

                    {{--
                    OVERLAY — complementary blue↔gold gradient
                    - Top: deep navy, matches the blue image and keeps the white navbar legible
                    - Middle: transparent, lets the image breathe
                    - Bottom: brand gold #C9A14A, anchors the CTA + headline
                    --}}
                    <div class="absolute inset-0 pointer-events-none" style="background-image:
                                            linear-gradient(
                                                to bottom,
                                                rgba(15, 23, 42, 0.75) 0%,      /* navy top */
                                                rgba(15, 23, 42, 0.25) 25%,
                                                rgba(15, 23, 42, 0.00) 45%,
                                                rgba(201, 161, 74, 0.15) 65%,   /* gold starts */
                                                rgba(201, 161, 74, 0.55) 100%   /* gold bottom */
                                            );">
                    </div>

                    {{-- CONTENT --}}
                    <div class="relative h-full flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-28 md:pt-36">
                            <div class="max-w-3xl">
                                @if($slide->title)
                                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-semibold leading-tight mb-4 text-white"
                                        style="text-shadow: 0 2px 12px rgba(15,23,42,0.55);">
                                        {{ $slide->title }}
                                    </h1>
                                @endif
                                @if($slide->subtitle)
                                    <p class="text-lg md:text-xl text-white/90 max-w-2xl mb-8"
                                        style="text-shadow: 0 1px 8px rgba(15,23,42,0.45);">
                                        {{ $slide->subtitle }}
                                    </p>
                                @endif
                                @if($slide->cta_label && $slide->cta_url)
                                    <a href="{{ $slide->cta_url }}"
                                        class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold text-sm transition shadow-lg"
                                        style="background-color:#C9A14A; color:#0f172a;"
                                        onmouseover="this.style.backgroundColor='#b58d36'"
                                        onmouseout="this.style.backgroundColor='#C9A14A'">
                                        {{ $slide->cta_label }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CONTROLS --}}
        @if($slides->count() > 1)
            <button type="button" @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full backdrop-blur-sm border border-white/30 text-white hover:bg-white/20 transition flex items-center justify-center"
                style="background-color: rgba(15, 23, 42, 0.35);" aria-label="Previous slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button" @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full backdrop-blur-sm border border-white/30 text-white hover:bg-white/20 transition flex items-center justify-center"
                style="background-color: rgba(15, 23, 42, 0.35);" aria-label="Next slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                @foreach($slides as $i => $slide)
                    <button type="button" @click="goTo({{ $i }})" class="h-2 rounded-full transition-all duration-300"
                        :class="current === {{ $i }} ? 'w-8' : 'w-2 hover:opacity-80'" :style="current === {{ $i }}
                                                    ? 'background-color:#C9A14A'
                                                    : 'background-color: rgba(255,255,255,0.4)'"
                        aria-label="Go to slide {{ $i + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif
    </section>
@endif