@extends('layouts.app')
@section('title', $project->name . ' — Nanchong Group')

@section('content')

@php
    $price = $project->price_summary;

    $videoList = $project->videos
        ->filter(fn($v) => $v->embed_url)
        ->map(fn($v) => [
            'type' => $v->type,
            'title' => $v->title,
            'src' => $v->embed_url,
            'poster' => $v->poster_url,
        ])
        ->values();
@endphp

{{-- ============== BREADCRUMBS ============== --}}
<div class="bg-cream border-b border-stone-line">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-charcoal-soft flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-camel transition">Home</a>
            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('projects.index') }}" class="hover:text-camel transition">Projects</a>
            @if($project->location)
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('projects.index', ['country' => $project->country?->slug, 'location' => $project->location]) }}"
                    class="hover:text-camel transition">{{ $project->location }}</a>
            @endif
            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-charcoal font-medium">{{ $project->name }}</span>
        </nav>
    </div>
</div>

{{-- ============== HERO STRIP (title + price) ============== --}}
<div class="bg-white border-b border-stone-line">
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            @if($project->country)
                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">
                    {{ $project->country->name }}{{ $project->location ? ' · ' . $project->location : '' }}
                </div>
            @endif
            <h1 class="text-3xl md:text-4xl font-semibold text-charcoal mb-1">{{ $project->name }}</h1>
            @if($project->address)
                <p class="text-charcoal-soft">{{ $project->address }}</p>
            @endif
        </div>

        <div class="inline-flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg self-start md:self-auto"
            style="background-image: linear-gradient(135deg, #9B897A 0%, #C09C7A 55%, #C9A14A 100%);">
            <svg class="w-6 h-6 text-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="leading-tight">
                <div class="text-[10px] uppercase tracking-widest text-charcoal/70 font-semibold">
                    {{ $price['has_price'] ? 'Starting from' : '' }}
                </div>
                <div class="text-xl md:text-2xl font-bold text-charcoal tracking-tight">
                    {{ $price['label'] }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============== MAIN ============== --}}
<x-section>

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- ============== LEFT: hero image + overview + features + location ============== --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- HERO IMAGE --}}
            <div class="aspect-[16/9] bg-ash-grey rounded-lg overflow-hidden">
                @if($project->cover_image)
                    <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                        <svg class="w-20 h-20 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M15 9h.01M9 13h.01M15 13h.01M9 17h.01M15 17h.01" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- OVERVIEW --}}
            <div class="bg-white border border-stone-line rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-charcoal mb-4">Project Overview</h2>
                @if($project->description)
                    <div class="text-charcoal-soft leading-relaxed whitespace-pre-line">
                        {{ $project->description }}
                    </div>
                @endif

                {{-- Key facts --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-stone-line">
                    @if($project->country)
                        <div>
                            <div class="text-xs uppercase tracking-wider text-camel mb-1">Country</div>
                            <div class="text-sm font-medium text-charcoal">{{ $project->country->name }}</div>
                        </div>
                    @endif
                    @if($project->location)
                        <div>
                            <div class="text-xs uppercase tracking-wider text-camel mb-1">Location</div>
                            <div class="text-sm font-medium text-charcoal">{{ $project->location }}</div>
                        </div>
                    @endif
                    @if($project->construction_area)
                        <div>
                            <div class="text-xs uppercase tracking-wider text-camel mb-1">Construction</div>
                            <div class="text-sm font-medium text-charcoal">{{ $project->construction_area }}</div>
                        </div>
                    @endif
                    @if($project->land_area)
                        <div>
                            <div class="text-xs uppercase tracking-wider text-camel mb-1">Land area</div>
                            <div class="text-sm font-medium text-charcoal">{{ $project->land_area }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- VIDEO TOUR --}}
            @if($videoList->count())
                <div class="bg-white border border-stone-line rounded-lg p-6" x-data="{
                    videos: @js($videoList),
                    current: 0,
                    playing: false,
                    select(i) { this.current = i; this.playing = false; },
                    get video() { return this.videos[this.current]; }
                }">
                    <h2 class="text-2xl font-semibold text-charcoal mb-4">
                        {{ $videoList->count() > 1 ? 'Project Videos' : 'Project Video' }}
                    </h2>

                    {{-- Player --}}
                    <div class="relative aspect-[16/9] rounded-lg overflow-hidden bg-charcoal">
                        {{-- Poster + play button (click to load the player) --}}
                        <button type="button" x-show="!playing" @click="playing = true"
                            class="absolute inset-0 w-full h-full group" aria-label="Play video">
                            <template x-if="video.poster">
                                <img :src="video.poster" :alt="video.title || '{{ addslashes($project->name) }} video'"
                                    class="w-full h-full object-cover" loading="lazy">
                            </template>
                            <span class="absolute inset-0 bg-black/25 group-hover:bg-black/35 transition"></span>
                            <span class="absolute inset-0 flex items-center justify-center">
                                <span
                                    class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white/90 flex items-center justify-center shadow-lg group-hover:scale-105 transition">
                                    <svg class="w-7 h-7 md:w-9 md:h-9 text-camel ml-1" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </span>
                            </span>
                        </button>

                        {{-- Iframe (YouTube / Vimeo), only mounted after click --}}
                        <template x-if="playing && video.type !== 'mp4'">
                            <iframe :src="video.src" class="absolute inset-0 w-full h-full" style="border:0"
                                allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen
                                referrerpolicy="strict-origin-when-cross-origin"
                                :title="video.title || '{{ addslashes($project->name) }} video'"></iframe>
                        </template>

                        {{-- Self-hosted MP4 --}}
                        <template x-if="playing && video.type === 'mp4'">
                            <video :src="video.src" :poster="video.poster" class="absolute inset-0 w-full h-full" controls
                                autoplay playsinline></video>
                        </template>
                    </div>

                    <p x-show="video.title" x-text="video.title" class="mt-3 text-sm font-medium text-charcoal"></p>

                    {{-- Thumbnails (only when there is more than one video) --}}
                    @if($videoList->count() > 1)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4">
                            <template x-for="(v, i) in videos" :key="i">
                                <button type="button" @click="select(i)"
                                    class="relative aspect-[16/9] rounded-md overflow-hidden bg-ash-grey border-2 transition"
                                    :class="current === i ? 'border-camel' : 'border-transparent opacity-80 hover:opacity-100'">
                                    <template x-if="v.poster">
                                        <img :src="v.poster" :alt="v.title || 'Video'" class="w-full h-full object-cover"
                                            loading="lazy">
                                    </template>
                                    <span class="absolute inset-0 flex items-center justify-center bg-black/20">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </span>
                                </button>
                            </template>
                        </div>
                    @endif
                </div>
            @endif

            {{-- FEATURES & AMENITIES --}}
            @if(!empty($project->features))
                <div class="bg-white border border-stone-line rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-charcoal mb-4">Features &amp; Amenities</h2>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($project->features as $feature)
                            <div class="flex items-start gap-3 text-charcoal-soft">
                                <svg class="w-5 h-5 text-camel shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- UNIT TYPES --}}
            @if($project->unitTypes->isNotEmpty())
                <div class="bg-white border border-stone-line rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-charcoal mb-4">Available Units</h2>

                    <div class="space-y-6">
                        @foreach($project->unitTypes as $unit)
                            @php
                                $unitImages = $unit->images->map(fn($img) => [
                                    'src' => asset('storage/' . $img->path),
                                    'alt' => $unit->name,
                                    'caption' => $unit->name . ' · ' . ($unit->unitTypeLookup?->name ?? 'Unit'),
                                ])->values();

                                $unitVideo = $unit->videos
                                    ->where('is_published', true)
                                    ->sortBy('sort_order')
                                    ->first();
                            @endphp

                            <div id="unit-{{ $unit->id }}"
                                class="border border-stone-line rounded-lg overflow-hidden scroll-mt-32">
                                <div class="grid md:grid-cols-2 gap-0">

                                    {{-- Unit gallery with inline lightbox --}}
                                    <div class="bg-ash-grey relative" x-data="{
                                        isOpen: false,
                                        current: 0,
                                        images: {{ json_encode($unitImages) }},
                                        get total() { return this.images.length },
                                        open(i) { this.current = i; this.isOpen = true; document.body.style.overflow = 'hidden' },
                                        close() { this.isOpen = false; document.body.style.overflow = '' },
                                        next() { this.current = (this.current + 1) % this.total },
                                        prev() { this.current = (this.current - 1 + this.total) % this.total }
                                    }" @keydown.escape.window="close()">

                                        @if($unit->images->isNotEmpty())
                                            @if($unit->images->count() === 1)
                                                <button type="button" @click="open(0)"
                                                    class="block aspect-square overflow-hidden hover:opacity-90 transition w-full">
                                                    <img src="{{ asset('storage/' . $unit->images->first()->path) }}"
                                                        alt="{{ $unit->name }}" class="w-full h-full object-cover" loading="lazy">
                                                </button>
                                            @elseif($unit->images->count() === 2)
                                                <div class="grid grid-cols-2 gap-0.5 h-full">
                                                    @foreach($unit->images as $i => $img)
                                                        <button type="button" @click="open({{ $i }})"
                                                            class="block aspect-square overflow-hidden hover:opacity-90 transition">
                                                            <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $unit->name }}"
                                                                class="w-full h-full object-cover" loading="lazy">
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @elseif($unit->images->count() === 3)
                                                <div class="grid grid-cols-2 grid-rows-2 gap-0.5 aspect-square">
                                                    @foreach($unit->images as $i => $img)
                                                        <button type="button" @click="open({{ $i }})"
                                                            class="block overflow-hidden hover:opacity-90 transition {{ $i === 0 ? 'row-span-2' : '' }}">
                                                            <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $unit->name }}"
                                                                class="w-full h-full object-cover" loading="lazy">
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="grid grid-cols-2 gap-0.5 aspect-square">
                                                    @foreach($unit->images->take(4) as $i => $img)
                                                        <button type="button" @click="open({{ $i }})"
                                                            class="block aspect-square overflow-hidden hover:opacity-90 transition relative">
                                                            <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $unit->name }}"
                                                                class="w-full h-full object-cover" loading="lazy">
                                                            @if($i === 3 && $unit->images->count() > 4)
                                                                <span
                                                                    class="absolute inset-0 flex items-center justify-center bg-charcoal/60 text-cream font-semibold text-lg">
                                                                    +{{ $unit->images->count() - 4 }}
                                                                </span>
                                                            @endif
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Lightbox overlay --}}
                                            <div x-show="isOpen" x-cloak
                                                class="fixed inset-0 z-[100] bg-charcoal/95 backdrop-blur-sm flex items-center justify-center p-4"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                @click.self="close()">

                                                <button type="button" @click="close()"
                                                    class="absolute top-4 right-4 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                                                    aria-label="Close">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>

                                                <div
                                                    class="absolute top-4 left-4 z-10 px-3 py-1.5 rounded-md bg-charcoal/60 text-cream text-sm">
                                                    <span x-text="current + 1"></span> / <span x-text="total"></span>
                                                </div>

                                                <button type="button" x-show="total > 1" @click.stop="prev()"
                                                    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                                                    aria-label="Previous">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                </button>

                                                <button type="button" x-show="total > 1" @click.stop="next()"
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                                                    aria-label="Next">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>

                                                <img :src="images[current]?.src" :alt="images[current]?.alt" @click.stop
                                                    class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl select-none">

                                                <div x-show="images[current]?.caption"
                                                    class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-2 rounded-md bg-charcoal/70 text-cream text-sm max-w-2xl text-center"
                                                    x-text="images[current]?.caption">
                                                </div>
                                            </div>
                                        @elseif($project->cover_image)
                                            <div class="aspect-square">
                                                <img src="{{ asset('storage/' . $project->cover_image) }}"
                                                    alt="{{ $unit->name }}" class="w-full h-full object-cover opacity-60">
                                            </div>
                                        @else
                                            <div class="aspect-square flex items-center justify-center text-charcoal-soft bg-cream">
                                                <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Unit details --}}
                                    <div class="p-5 flex flex-col">
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <div>
                                                <h3 class="text-lg font-semibold text-charcoal">
                                                    {{ $unit->name }}
                                                    @if($unit->unitTypeLookup)
                                                        <span class="text-xs font-normal text-charcoal-soft">
                                                            · {{ $unit->unitTypeLookup->name }}
                                                        </span>
                                                    @endif
                                                </h3>
                                                <div class="text-xs uppercase tracking-wider text-camel font-medium mt-1">
                                                    {{ ucfirst($unit->purpose) }}
                                                    @if($unit->style) · {{ $unit->style->name }} @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                @if($unit->price_kes)
                                                    <div class="text-lg font-bold text-charcoal">
                                                        KES {{ number_format((float) $unit->price_kes, 0) }}
                                                    </div>
                                                    @if($unit->price_negotiable)
                                                        <div class="text-xs text-charcoal-soft">Negotiable</div>
                                                    @endif
                                                @else
                                                    <div class="text-sm font-medium text-charcoal-soft">Price on request</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-3 mt-3 pt-3 border-t border-stone-line text-sm">
                                            @if($unit->bedrooms !== null)
                                                <div>
                                                    <div class="text-xs text-camel uppercase tracking-wider mb-0.5">Bedrooms</div>
                                                    <div class="font-medium text-charcoal">{{ $unit->bedrooms }}</div>
                                                </div>
                                            @endif
                                            @if($unit->size_min_sqm || $unit->size_max_sqm)
                                                <div>
                                                    <div class="text-xs text-camel uppercase tracking-wider mb-0.5">Size</div>
                                                    <div class="font-medium text-charcoal">
                                                        {{ $unit->size_min_sqm ?? '' }}
                                                        @if($unit->size_max_sqm && $unit->size_max_sqm != $unit->size_min_sqm)
                                                            – {{ $unit->size_max_sqm }}
                                                        @endif
                                                        m²
                                                    </div>
                                                </div>
                                            @endif
                                            @if($unit->style)
                                                <div>
                                                    <div class="text-xs text-camel uppercase tracking-wider mb-0.5">Style</div>
                                                    <div class="font-medium text-charcoal">{{ $unit->style->name }}</div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Unit-specific amenities --}}
                                        @if(!empty($unit->features))
                                            <div class="mt-3 pt-3 border-t border-stone-line" x-data="{ open: true }">
                                                <button type="button" @click="open = !open"
                                                    class="w-full flex items-center justify-between text-xs uppercase tracking-wider text-camel font-semibold">
                                                    <span>This unit includes ({{ count($unit->features) }})</span>
                                                    <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <ul x-show="open" x-cloak class="grid grid-cols-2 gap-1.5 mt-2">
                                                    @foreach($unit->features as $feature)
                                                        <li class="flex items-start gap-2 text-xs text-charcoal-soft">
                                                            <svg class="w-3.5 h-3.5 text-camel shrink-0 mt-0.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            <span>{{ $feature }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        {{-- Unit video --}}
                                        @if($unitVideo)
                                            <div class="mt-3 pt-3 border-t border-stone-line">
                                                <div class="text-xs uppercase tracking-wider text-camel font-semibold mb-2">
                                                    Unit video
                                                </div>

                                                <div x-data="{ playing: false }"
                                                    class="relative aspect-video bg-charcoal rounded-md overflow-hidden cursor-pointer">

                                                    <button type="button" x-show="!playing" @click="playing = true"
                                                        class="absolute inset-0 w-full h-full flex items-center justify-center group">

                                                        @if($unitVideo->poster_url)
                                                            <img src="{{ $unitVideo->poster_url }}"
                                                                alt="{{ $unitVideo->title ?? $unit->name }}"
                                                                class="absolute inset-0 w-full h-full object-cover opacity-90">
                                                        @endif

                                                        <div
                                                            class="relative z-10 w-12 h-12 rounded-full bg-cream/95 backdrop-blur-sm flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                                            <svg class="w-5 h-5 text-charcoal ml-0.5" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z" />
                                                            </svg>
                                                        </div>
                                                    </button>

                                                    <div x-show="playing" x-cloak class="absolute inset-0">
                                                        @if($unitVideo->type === 'mp4')
                                                            <video src="{{ $unitVideo->embed_url }}" controls autoplay playsinline
                                                                class="absolute inset-0 w-full h-full object-contain"></video>
                                                        @else
                                                            <iframe src="{{ $unitVideo->embed_url }}"
                                                                title="{{ $unitVideo->title ?? $unit->name }}"
                                                                class="absolute inset-0 w-full h-full border-0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                                                allowfullscreen></iframe>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($unitVideo->title)
                                                    <p class="text-xs text-charcoal-soft mt-2">{{ $unitVideo->title }}</p>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- CTA --}}
                                        <div class="mt-auto pt-4">
                                            <a href="https://wa.me/{{ $project->whatsapp }}?text={{ urlencode("Hi, I'm interested in the {$unit->name} at {$project->name}.") }}"
                                                target="_blank" rel="noopener"
                                                class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1EBE5A] transition">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                                </svg>
                                                Enquire about this unit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- LOCATION + MAP --}}
            <div class="bg-white border border-stone-line rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-charcoal mb-4">Location</h2>
                @if($project->address)
                    <p class="text-charcoal-soft mb-4">{{ $project->address }}</p>
                @endif

                @if($project->latitude && $project->longitude)
                    <div class="aspect-[16/9] rounded-lg overflow-hidden border border-stone-line">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $project->longitude - 0.01 }},{{ $project->latitude - 0.01 }},{{ $project->longitude + 0.01 }},{{ $project->latitude + 0.01 }}&layer=mapnik&marker={{ $project->latitude }},{{ $project->longitude }}"
                            class="w-full h-full" style="border:0" loading="lazy"
                            title="{{ $project->name }} location"></iframe>
                    </div>
                    <a href="https://www.openstreetmap.org/?mlat={{ $project->latitude }}&mlon={{ $project->longitude }}#map=16/{{ $project->latitude }}/{{ $project->longitude }}"
                        target="_blank" rel="noopener" class="inline-block mt-3 text-sm text-camel hover:text-dusty-taupe">
                        Open in OpenStreetMap →
                    </a>
                @else
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($project->address ?? $project->location ?? $project->name) }}"
                        target="_blank" rel="noopener"
                        class="block aspect-[16/9] rounded-lg overflow-hidden border border-stone-line bg-cream relative group">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center text-charcoal-soft group-hover:text-camel transition">
                            <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm font-medium">Open in Google Maps</span>
                        </div>
                    </a>
                    <p class="text-xs text-charcoal-soft mt-2">
                        Add latitude / longitude in admin to embed the map directly.
                    </p>
                @endif
            </div>

            {{-- RELATED INSIGHT --}}
            @isset($insight)
                @if($insight)
                    <div class="bg-camel/10 border-l-4 border-camel rounded-r-lg p-6">
                        <div class="text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                            Insight · {{ $project->location }}
                        </div>
                        <h3 class="text-lg font-semibold text-charcoal mb-2">{{ $insight->title }}</h3>
                        @if($insight->summary)
                            <p class="text-sm text-charcoal-soft mb-4">{{ $insight->summary }}</p>
                        @endif
                        <a href="{{ route('insights.show', $insight) }}" class="btn-secondary text-sm">
                            Read the guide →
                        </a>
                    </div>
                @endif
            @endisset
        </div>

        {{-- ============== RIGHT: gallery + enquiry form ============== --}}
        <aside class="lg:col-span-1 space-y-6">

            {{-- GALLERY --}}
            @if($project->images->count())
                @php
                    $galleryImages = $project->images->map(fn($img) => [
                        'src' => asset('storage/' . $img->path),
                        'alt' => $project->name,
                        'caption' => $project->name,
                    ])->values();
                @endphp

                <div class="bg-white border border-stone-line rounded-lg p-5" x-data="{
                    isOpen: false,
                    current: 0,
                    images: {{ json_encode($galleryImages) }},
                    get total() { return this.images.length },
                    open(i) { this.current = i; this.isOpen = true; document.body.style.overflow = 'hidden' },
                    close() { this.isOpen = false; document.body.style.overflow = '' },
                    next() { this.current = (this.current + 1) % this.total },
                    prev() { this.current = (this.current - 1 + this.total) % this.total }
                }" @keydown.escape.window="close()">

                    <h3 class="text-lg font-semibold text-charcoal mb-4">Project Gallery</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($project->images as $i => $img)
                            <button type="button" @click="open({{ $i }})"
                                class="block aspect-square rounded-md overflow-hidden bg-ash-grey hover:opacity-90 transition">
                                <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $project->name }}"
                                    class="w-full h-full object-cover" loading="lazy">
                            </button>
                        @endforeach
                    </div>

                    {{-- Lightbox overlay --}}
                    <div x-show="isOpen" x-cloak
                        class="fixed inset-0 z-[100] bg-charcoal/95 backdrop-blur-sm flex items-center justify-center p-4"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="close()">

                        <button type="button" @click="close()"
                            class="absolute top-4 right-4 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                            aria-label="Close">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="absolute top-4 left-4 z-10 px-3 py-1.5 rounded-md bg-charcoal/60 text-cream text-sm">
                            <span x-text="current + 1"></span> / <span x-text="total"></span>
                        </div>

                        <button type="button" x-show="total > 1" @click.stop="prev()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                            aria-label="Previous">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <button type="button" x-show="total > 1" @click.stop="next()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                            aria-label="Next">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <img :src="images[current]?.src" :alt="images[current]?.alt" @click.stop
                            class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl select-none">
                    </div>
                </div>
            @endif

            {{-- ENQUIRY FORM --}}
            <div class="bg-white border border-stone-line rounded-lg p-5 sticky top-32">

                {{-- Price strip ($price is defined at the top of the file) --}}
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-stone-line">
                    <span class="text-xs uppercase tracking-wider font-semibold text-charcoal-soft">Price</span>
                    <span class="text-lg font-bold" style="background-image: linear-gradient(135deg, #C09C7A, #C9A14A);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        color: transparent;">
                        {{ $price['label'] }}
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-charcoal mb-1">Enquire about this project</h3>
                <p class="text-xs text-charcoal-soft mb-4">We'll send your enquiry via WhatsApp.</p>

                <div x-data="{
                    name: '',
                    phone: '',
                    message: '',
                    get whatsappUrl() {
                        const text =
                            '*Project enquiry*' + '%0A' +
                            'Project: {{ urlencode($project->name) }}' + '%0A' +
                            'Name: ' + encodeURIComponent(this.name) + '%0A' +
                            'Phone: ' + encodeURIComponent(this.phone) + '%0A' +
                            'Message: ' + encodeURIComponent(this.message);
                        return 'https://wa.me/{{ $project->whatsapp }}?text=' + text;
                    },
                    send() {
                        if (!this.name.trim() || !this.phone.trim()) {
                            alert('Please fill in your name and phone number.');
                            return;
                        }
                        window.open(this.whatsappUrl, '_blank');
                    }
                }" class="space-y-4">

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Your
                            Name</label>
                        <input type="text" x-model="name" required
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Phone /
                            WhatsApp</label>
                        <input type="tel" x-model="phone" required placeholder="+254 7XX XXX XXX"
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Your
                            Message</label>
                        <textarea x-model="message" rows="3"
                            placeholder="I'm interested in this project. Please share more details."
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm"></textarea>
                    </div>

                    <button type="button" @click="send()"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-md bg-[#25D366] text-white font-semibold text-sm hover:bg-[#1EBE5A] transition shadow-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Send via WhatsApp
                    </button>

                    <p class="text-[11px] text-charcoal-soft text-center">
                        You'll be redirected to WhatsApp with your message pre-filled.
                    </p>
                </div>
            </div>
        </aside>
    </div>

    {{-- ============== RELATED PROJECTS ============== --}}
    @if($relatedProjects->count())
        <div class="mt-16 pt-10 border-t border-stone-line">
            <h2 class="text-2xl font-semibold text-charcoal mb-6">Other projects in {{ $project->country?->name }}</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProjects as $related)
                    <x-project-card :project="$related" />
                @endforeach
            </div>
        </div>
    @endif
</x-section>

@endsection