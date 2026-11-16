@extends('layouts.app')

@php
    $project = $unit->project;
    $priceLabel = $unit->price_kes
        ? 'KES ' . number_format((float) $unit->price_kes, 0)
        : 'Price on request';
    $bedroomsLabel = match ((int) $unit->bedrooms) {
        0 => 'Studio',
        1 => '1 Bedroom',
        2 => '2 Bedroom',
        3 => '3 Bedroom',
        4 => '4+ Bedroom',
        default => $unit->bedrooms !== null ? $unit->bedrooms . ' Bedrooms' : '—',
    };
@endphp

@section('title', $unit->name . ' at ' . ($project?->name ?? 'Nanchong Group') . ' — Nanchong Group')
@section('meta_description', 'View details for the ' . $unit->name . ' at ' . ($project?->name ?? '') . '. ' . $priceLabel . ' · ' . $bedroomsLabel . '.')

@section('content')

    {{-- BREADCRUMBS --}}
    <div class="bg-cream border-b border-stone-line">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-charcoal-soft flex-wrap" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-camel transition">Home</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('projects.index') }}" class="hover:text-camel transition">Projects</a>
                @if($project)
                    <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('projects.show', $project) }}" class="hover:text-camel transition">
                        {{ $project->name }}
                    </a>
                @endif
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-charcoal font-medium">{{ $unit->name }}</span>
            </nav>
        </div>
    </div>

    {{-- HERO STRIP --}}
    <div class="bg-white border-b border-stone-line">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">
                    {{ $project?->country?->name }}{{ $project?->location ? ' · ' . $project->location : '' }}
                </div>
                <h1 class="text-3xl md:text-4xl font-semibold text-charcoal mb-1">
                    {{ $unit->name }}
                    @if($unit->unitTypeLookup)
                        <span class="text-base font-normal text-charcoal-soft">
                            · {{ $unit->unitTypeLookup->name }}
                        </span>
                    @endif
                </h1>
                @if($project)
                    <a href="{{ route('projects.show', $project) }}" class="text-charcoal-soft hover:text-camel transition">
                        {{ $project->name }}{{ $project->address ? ' — ' . $project->address : '' }}
                    </a>
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
                        {{ $unit->price_kes ? 'Price' : '' }}
                        @if($unit->price_negotiable) · Negotiable @endif
                    </div>
                    <div class="text-xl md:text-2xl font-bold text-charcoal tracking-tight">
                        {{ $priceLabel }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-section>
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- LEFT: images + details + amenities + videos --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- UNIT IMAGE GALLERY --}}
                @if($unit->images->isNotEmpty())
                            <div x-data="{
                                        isOpen: false,
                                        current: 0,
                                        images: {{ json_encode($unit->images->map(fn($img) => [
                        'src' => asset('storage/' . $img->path),
                        'alt' => $unit->name,
                        'caption' => $unit->name,
                    ])->values()) }},
                                        get total() { return this.images.length },
                                        open(i) { this.current = i; this.isOpen = true; document.body.style.overflow = 'hidden' },
                                        close() { this.isOpen = false; document.body.style.overflow = '' },
                                        next() { this.current = (this.current + 1) % this.total },
                                        prev() { this.current = (this.current - 1 + this.total) % this.total }
                                     }" @keydown.escape.window="close()">

                                {{-- Main image --}}
                                <div class="aspect-[16/9] bg-ash-grey rounded-lg overflow-hidden relative group cursor-pointer"
                                    @click="open(0)">
                                    <img src="{{ asset('storage/' . $unit->images->first()->path) }}" alt="{{ $unit->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if($unit->images->count() > 1)
                                        <div
                                            class="absolute bottom-3 right-3 px-3 py-1.5 rounded-md bg-charcoal/70 text-cream text-xs font-medium flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $unit->images->count() }} photos
                                        </div>
                                    @endif
                                </div>

                                {{-- Thumbnails strip --}}
                                @if($unit->images->count() > 1)
                                    <div class="grid grid-cols-4 gap-2 mt-2">
                                        @foreach($unit->images->take(4) as $i => $img)
                                            <button type="button" @click="open({{ $i }})"
                                                class="aspect-square rounded overflow-hidden bg-ash-grey hover:opacity-90 transition">
                                                <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $unit->name }}"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Lightbox --}}
                                <div x-show="isOpen" x-cloak
                                    class="fixed inset-0 z-[100] bg-charcoal/95 backdrop-blur-sm flex items-center justify-center p-4"
                                    @click.self="close()">
                                    <button type="button" @click="close()"
                                        class="absolute top-4 right-4 z-10 w-12 h-12 rounded-full bg-cream/10 border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <div class="absolute top-4 left-4 z-10 px-3 py-1.5 rounded-md bg-charcoal/60 text-cream text-sm">
                                        <span x-text="current + 1"></span> / <span x-text="total"></span>
                                    </div>
                                    <button type="button" x-show="total > 1" @click.stop="prev()"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button type="button" x-show="total > 1" @click.stop="next()"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <img :src="images[current]?.src" :alt="images[current]?.alt" @click.stop
                                        class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl">
                                </div>
                            </div>
                @elseif($project?->cover_image)
                    <div class="aspect-[16/9] bg-ash-grey rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $unit->name }}"
                            class="w-full h-full object-cover opacity-80">
                    </div>
                @endif

                {{-- DETAILS GRID --}}
                <div class="bg-white border border-stone-line rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-charcoal mb-4">Unit Details</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <div class="text-xs uppercase tracking-wider text-camel mb-1">Bedrooms</div>
                            <div class="text-sm font-medium text-charcoal">{{ $bedroomsLabel }}</div>
                        </div>
                        @if($unit->size_min_sqm || $unit->size_max_sqm)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Size</div>
                                <div class="text-sm font-medium text-charcoal">
                                    {{ $unit->size_min_sqm ? (int) $unit->size_min_sqm : '' }}
                                    @if($unit->size_max_sqm && $unit->size_max_sqm != $unit->size_min_sqm)
                                        – {{ (int) $unit->size_max_sqm }}
                                    @endif
                                    m²
                                </div>
                            </div>
                        @endif
                        @if($unit->style)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Style</div>
                                <div class="text-sm font-medium text-charcoal">{{ $unit->style->name }}</div>
                            </div>
                        @endif
                        @if($unit->unitTypeLookup)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Type</div>
                                <div class="text-sm font-medium text-charcoal">{{ $unit->unitTypeLookup->name }}</div>
                            </div>
                        @endif
                        <div>
                            <div class="text-xs uppercase tracking-wider text-camel mb-1">Purpose</div>
                            <div class="text-sm font-medium text-charcoal">{{ ucfirst($unit->purpose) }}</div>
                        </div>
                        @if($unit->category)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Category</div>
                                <div class="text-sm font-medium text-charcoal">{{ ucfirst($unit->category) }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- AMENITIES --}}
                @if(!empty($unit->features))
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">This Unit Includes</h2>
                        <div class="grid sm:grid-cols-2 gap-3">
                            @foreach($unit->features as $feature)
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

                {{-- UNIT VIDEO --}}
                @php
                    $unitVideo = $unit->videos->where('is_published', true)->sortBy('sort_order')->first();
                @endphp
                @if($unitVideo)
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">Unit Video</h2>
                        <div x-data="{ playing: false }" class="relative aspect-video bg-charcoal rounded-md overflow-hidden">
                            <button type="button" x-show="!playing" @click="playing = true"
                                class="absolute inset-0 w-full h-full flex items-center justify-center group">
                                @if($unitVideo->poster_url)
                                    <img src="{{ $unitVideo->poster_url }}" alt="{{ $unitVideo->title ?? $unit->name }}"
                                        class="absolute inset-0 w-full h-full object-cover opacity-90">
                                @endif
                                <div
                                    class="relative z-10 w-16 h-16 rounded-full bg-cream/95 flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                    <svg class="w-7 h-7 text-charcoal ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </button>
                            <div x-show="playing" x-cloak class="absolute inset-0">
                                @if($unitVideo->type === 'mp4')
                                    <video src="{{ $unitVideo->embed_url }}" controls autoplay playsinline
                                        class="absolute inset-0 w-full h-full object-contain"></video>
                                @else
                                    <iframe src="{{ $unitVideo->embed_url }}" title="{{ $unitVideo->title ?? $unit->name }}"
                                        class="absolute inset-0 w-full h-full border-0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                        allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                        @if($unitVideo->title)
                            <p class="text-sm text-charcoal-soft mt-3">{{ $unitVideo->title }}</p>
                        @endif
                    </div>
                @endif

                {{-- ABOUT THE PROJECT --}}
                @if($project?->description)
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">About {{ $project->name }}</h2>
                        <div class="text-charcoal-soft leading-relaxed whitespace-pre-line line-clamp-4">
                            {{ $project->description }}
                        </div>
                        <a href="{{ route('projects.show', $project) }}"
                            class="inline-block mt-4 text-sm font-medium text-camel hover:text-dusty-taupe">
                            View full project →
                        </a>
                    </div>
                @endif

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

            {{-- RIGHT: enquiry form + project info --}}
            <aside class="lg:col-span-1 space-y-6">

                {{-- ENQUIRY FORM --}}
                <div class="bg-white border border-stone-line rounded-lg p-5 sticky top-32">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-stone-line">
                        <span class="text-xs uppercase tracking-wider font-semibold text-charcoal-soft">Price</span>
                        <span class="text-lg font-bold" style="background-image: linear-gradient(135deg, #C09C7A, #C9A14A);
                                     -webkit-background-clip: text;
                                     -webkit-text-fill-color: transparent;
                                     background-clip: text;">
                            {{ $priceLabel }}
                        </span>
                    </div>

                    <h3 class="text-lg font-semibold text-charcoal mb-1">Enquire about this unit</h3>
                    <p class="text-xs text-charcoal-soft mb-4">We'll send your enquiry via WhatsApp.</p>

                    <div x-data="{
                            name: '',
                            phone: '',
                            message: '',
                            get whatsappUrl() {
                                const text =
                                    '*Unit enquiry*' + '%0A' +
                                    'Unit: {{ urlencode($unit->name) }}' + '%0A' +
                                    'Project: {{ urlencode($project?->name ?? '') }}' + '%0A' +
                                    'Name: ' + encodeURIComponent(this.name) + '%0A' +
                                    'Phone: ' + encodeURIComponent(this.phone) + '%0A' +
                                    'Message: ' + encodeURIComponent(this.message);
                                return 'https://wa.me/{{ $project?->whatsapp ?? '254710998888' }}?text=' + text;
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
                                placeholder="I'm interested in this unit. Please share more details."
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
                    </div>
                </div>

                {{-- PROJECT LINK CARD --}}
                @if($project)
                    <div class="bg-white border border-stone-line rounded-lg p-5">
                        <div class="text-xs uppercase tracking-wider font-semibold text-camel mb-3">Part of</div>
                        <a href="{{ route('projects.show', $project) }}" class="block group">
                            @if($project->cover_image)
                                <div class="aspect-[16/9] rounded-md overflow-hidden bg-ash-grey mb-3">
                                    <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                            <div class="font-semibold text-charcoal group-hover:text-camel transition">
                                {{ $project->name }}
                            </div>
                            @if($project->address)
                                <div class="text-xs text-charcoal-soft mt-1">{{ $project->address }}</div>
                            @endif
                        </a>
                    </div>
                @endif
            </aside>
        </div>

        {{-- SIMILAR UNITS --}}
        @if($similarUnits->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-stone-line">
                <h2 class="text-2xl font-semibold text-charcoal mb-6">Similar Units</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($similarUnits as $similar)
                        <x-unit-card :unit="$similar" />
                    @endforeach
                </div>
            </div>
        @endif
    </x-section>

@endsection