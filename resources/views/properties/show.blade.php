@extends('layouts.app')
@section('title', $property->title . ' — Buy Property Nairobi')

@section('content')

    @php
        $price = $property->price_label;
        $galleryImages = $property->images->map(fn($img) => [
            'src' => asset('storage/' . $img->path),
            'alt' => $property->title,
        ])->values();

        $videoList = $property->videos->map(fn($v) => [
            'type' => $v->type,
            'title' => $v->title,
            'src' => $v->embed_url,
            'poster' => $v->poster_url,
        ])->values();
    @endphp

    {{-- Breadcrumbs --}}
    <div class="bg-cream border-b border-stone-line">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-charcoal-soft flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-camel">Home</a>
                <span class="opacity-50">›</a>
                    <a href="{{ route('properties.index') }}" class="hover:text-camel">Properties</a>
                    @if($property->location)
                        <span class="opacity-50">›</span>
                        <a href="{{ route('properties.index', ['location' => $property->location]) }}"
                            class="hover:text-camel">{{ $property->location }}</a>
                    @endif
                    <span class="opacity-50">›</span>
                    <span class="text-charcoal font-medium truncate">{{ $property->title }}</span>
            </nav>
        </div>
    </div>

    {{-- Hero strip --}}
    <div class="bg-white border-b border-stone-line">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">
                    {{ $property->country?->name }}@if($property->location) · {{ $property->location }} @endif
                </div>
                <h1 class="text-3xl md:text-4xl font-semibold text-charcoal mb-1">{{ $property->title }}</h1>
                @if($property->address)
                    <p class="text-charcoal-soft">{{ $property->address }}</p>
                @endif
                <div class="flex flex-wrap gap-4 mt-3 text-sm text-charcoal-soft">
                    @if($property->bedrooms) <span>{{ $property->bedrooms }} bed</span> @endif
                    @if($property->bathrooms) <span>{{ $property->bathrooms }} bath</span> @endif
                    @if($property->size_sqm) <span>{{ number_format($property->size_sqm, 0) }} m²</span> @endif
                    <span class="inline-flex items-center gap-1">
                        <span
                            class="w-2 h-2 rounded-full
                            {{ $property->status === 'available' ? 'bg-green-500' : ($property->status === 'sold' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
                        {{ $property->status_label }}
                    </span>
                </div>
            </div>

            <div class="inline-flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg self-start md:self-auto"
                style="background-image: linear-gradient(135deg, #9B897A 0%, #C09C7A 55%, #C9A14A 100%);">
                <svg class="w-6 h-6 text-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="leading-tight">
                    <div class="text-[10px] uppercase tracking-widest text-charcoal/70 font-semibold">
                        {{ $price['has_price'] ? 'Asking price' : '' }}
                    </div>
                    <div class="text-xl md:text-2xl font-bold text-charcoal tracking-tight">{{ $price['label'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <x-section>
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Cover --}}
                <div class="aspect-[16/9] bg-ash-grey rounded-lg overflow-hidden">
                    @if($property->cover_image)
                        <img src="{{ asset('storage/' . $property->cover_image) }}" alt="{{ $property->title }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                            <svg class="w-20 h-20 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 21h18M5 21V7l7-4 7 4v14" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Overview --}}
                <div class="bg-white border border-stone-line rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-charcoal mb-4">About this property</h2>
                    @if($property->description)
                        <div class="text-charcoal-soft leading-relaxed whitespace-pre-line">{{ $property->description }}</div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-stone-line">
                        @if($property->property_type)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Type</div>
                                <div class="text-sm font-medium text-charcoal">{{ $property->property_type }}</div>
                            </div>
                        @endif
                        @if($property->category)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Category</div>
                                <div class="text-sm font-medium text-charcoal">{{ ucfirst($property->category) }}</div>
                            </div>
                        @endif
                        @if($property->bedrooms)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Bedrooms</div>
                                <div class="text-sm font-medium text-charcoal">{{ $property->bedrooms }}</div>
                            </div>
                        @endif
                        @if($property->size_sqm)
                            <div>
                                <div class="text-xs uppercase tracking-wider text-camel mb-1">Size</div>
                                <div class="text-sm font-medium text-charcoal">{{ number_format($property->size_sqm, 0) }} m²
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Highlights --}}
                @if($property->highlights->count())
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">Highlights</h2>
                        <ul class="grid sm:grid-cols-2 gap-3">
                            @foreach($property->highlights as $h)
                                <li class="flex items-start gap-3 text-charcoal-soft">
                                    <svg class="w-5 h-5 text-camel shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm">{{ $h->label }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Features --}}
                @if(!empty($property->features))
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">Features &amp; Amenities</h2>
                        <div class="grid sm:grid-cols-2 gap-3">
                            @foreach($property->features as $feature)
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

                {{-- Videos --}}
                @if($videoList->count())
                    <div class="bg-white border border-stone-line rounded-lg p-6" x-data="{
                            videos: @js($videoList),
                            current: 0,
                            playing: false,
                            select(i) { this.current = i; this.playing = false; },
                            get video() { return this.videos[this.current]; }
                        }">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">
                            {{ $videoList->count() > 1 ? 'Property Videos' : 'Property Video' }}
                        </h2>

                        <div class="relative aspect-video rounded-lg overflow-hidden bg-charcoal">
                            <button type="button" x-show="!playing" @click="playing = true"
                                class="absolute inset-0 w-full h-full group">
                                <template x-if="video.poster">
                                    <img :src="video.poster" :alt="video.title || ''" class="w-full h-full object-cover">
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

                            <template x-if="playing && video.type !== 'mp4'">
                                <iframe :src="video.src" class="absolute inset-0 w-full h-full" style="border:0"
                                    allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
                            </template>

                            <template x-if="playing && video.type === 'mp4'">
                                <video :src="video.src" :poster="video.poster" class="absolute inset-0 w-full h-full" controls
                                    autoplay playsinline></video>
                            </template>
                        </div>

                        @if($videoList->count() > 1)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4">
                                <template x-for="(v, i) in videos" :key="i">
                                    <button type="button" @click="select(i)"
                                        class="relative aspect-video rounded-md overflow-hidden bg-ash-grey border-2 transition"
                                        :class="current === i ? 'border-camel' : 'border-transparent opacity-80 hover:opacity-100'">
                                        <template x-if="v.poster">
                                            <img :src="v.poster" :alt="v.title || 'Video'" class="w-full h-full object-cover">
                                        </template>
                                    </button>
                                </template>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Location --}}
                @if($property->latitude && $property->longitude)
                    <div class="bg-white border border-stone-line rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-charcoal mb-4">Location</h2>
                        @if($property->address)
                            <p class="text-charcoal-soft mb-4">{{ $property->address }}</p>
                        @endif
                        <div id="property-map-{{ $property->id }}"
                            class="aspect-[16/9] rounded-lg overflow-hidden border border-stone-line"
                            style="width: 100%; z-index: 0;"></div>
                        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm">
                            <a href="https://www.openstreetmap.org/?mlat={{ $property->latitude }}&mlon={{ $property->longitude }}#map=16/{{ $property->latitude }}/{{ $property->longitude }}"
                                target="_blank" rel="noopener" class="text-camel hover:text-dusty-taupe">Open in OpenStreetMap
                                →</a>
                            <a href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}&hl=en"
                                target="_blank" rel="noopener" class="text-camel hover:text-dusty-taupe">Open in Google Maps
                                →</a>
                        </div>
                        <script>
                            (function () {
                                const id = 'property-map-{{ $property->id }}';
                                const lat = {{ $property->latitude }};
                                const lng = {{ $property->longitude }};
                                const key = @js(config('services.maptiler.key'));

                                function init() {
                                    const el = document.getElementById(id);
                                    if (!el || el.dataset.init) return;
                                    el.dataset.init = '1';
                                    const m = L.map(id, { scrollWheelZoom: false }).setView([lat, lng], 15);
                                    L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=' + key + '&language=en', {
                                        attribution: '© MapTiler © OpenStreetMap contributors',
                                        maxZoom: 20,
                                    }).addTo(m);
                                    L.marker([lat, lng]).addTo(m);
                                    setTimeout(() => m.invalidateSize(), 150);
                                }

                                function ensureLeaflet(cb) {
                                    if (window.L) return cb();
                                    if (!document.querySelector('link[data-leaflet-css]')) {
                                        const c = document.createElement('link');
                                        c.rel = 'stylesheet';
                                        c.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                                        c.setAttribute('data-leaflet-css', '1');
                                        document.head.appendChild(c);
                                    }
                                    if (document.querySelector('script[data-leaflet-js]')) {
                                        document.querySelector('script[data-leaflet-js]').addEventListener('load', cb);
                                        return;
                                    }
                                    const s = document.createElement('script');
                                    s.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                                    s.setAttribute('data-leaflet-js', '1');
                                    s.onload = cb;
                                    document.head.appendChild(s);
                                }

                                ensureLeaflet(() => {
                                    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
                                    else init();
                                });
                            })();
                        </script>
                    </div>
                @endif
            </div>

            {{-- RIGHT sidebar --}}
            <aside class="lg:col-span-1 space-y-6">

                {{-- Gallery --}}
                @if($property->images->count())
                    <div class="bg-white border border-stone-line rounded-lg p-5" x-data="{
                            isOpen: false, current: 0, images: @js($galleryImages), get total() { return this.images.length },
                            open(i) { this.current = i; this.isOpen = true; document.body.style.overflow = 'hidden' },
                            close() { this.isOpen = false; document.body.style.overflow = '' },
                            next() { this.current = (this.current + 1) % this.total },
                            prev() { this.current = (this.current - 1 + this.total) % this.total }
                        }" @keydown.escape.window="close()">
                        <h3 class="text-lg font-semibold text-charcoal mb-4">Gallery</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($property->images as $i => $img)
                                <button type="button" @click="open({{ $i }})"
                                    class="block aspect-square rounded-md overflow-hidden bg-ash-grey hover:opacity-90 transition">
                                    <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $property->title }}"
                                        class="w-full h-full object-cover" loading="lazy">
                                </button>
                            @endforeach
                        </div>

                        <div x-show="isOpen" x-cloak
                            class="fixed inset-0 z-[100] bg-charcoal/95 flex items-center justify-center p-4"
                            @click.self="close()">
                            <button type="button" @click="close()"
                                class="absolute top-4 right-4 z-10 w-12 h-12 rounded-full bg-cream/10 text-cream hover:bg-cream/25 flex items-center justify-center">✕</button>
                            <button type="button" x-show="total > 1" @click.stop="prev()"
                                class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 text-cream hover:bg-cream/25 flex items-center justify-center">‹</button>
                            <button type="button" x-show="total > 1" @click.stop="next()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 text-cream hover:bg-cream/25 flex items-center justify-center">›</button>
                            <img :src="images[current]?.src" :alt="images[current]?.alt" @click.stop
                                class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl">
                        </div>
                    </div>
                @endif

                {{-- Enquiry form --}}
                <div class="bg-white border border-stone-line rounded-lg p-5 sticky top-32">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-stone-line">
                        <span class="text-xs uppercase tracking-wider font-semibold text-charcoal-soft">Price</span>
                        <span class="text-lg font-bold" style="background-image: linear-gradient(135deg, #C09C7A, #C9A14A);
                            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                            background-clip: text; color: transparent;">{{ $price['label'] }}</span>
                    </div>

                    <h3 class="text-lg font-semibold text-charcoal mb-1">Enquire about this property</h3>
                    <p class="text-xs text-charcoal-soft mb-4">We'll send your enquiry via WhatsApp.</p>

                    <div x-data="{
                        name: '', phone: '', message: '',
                        get url() {
                            const t = '*Property enquiry*' + '%0A' +
                                'Property: {{ urlencode($property->title) }}' + '%0A' +
                                'Name: ' + encodeURIComponent(this.name) + '%0A' +
                                'Phone: ' + encodeURIComponent(this.phone) + '%0A' +
                                'Message: ' + encodeURIComponent(this.message);
                            return 'https://wa.me/{{ $property->whatsapp }}?text=' + t;
                        },
                        send() {
                            if (!this.name.trim() || !this.phone.trim()) return;
                            window.open(this.url, '_blank');
                        }
                    }" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Your
                                Name</label>
                            <input type="text" x-model="name" required
                                class="w-full border-stone-line rounded-md text-sm focus:ring-camel focus:border-camel">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Phone /
                                WhatsApp</label>
                            <input type="tel" x-model="phone" required placeholder="+254 7XX XXX XXX"
                                class="w-full border-stone-line rounded-md text-sm focus:ring-camel focus:border-camel">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Message</label>
                            <textarea x-model="message" rows="3" placeholder="I'm interested in this property."
                                class="w-full border-stone-line rounded-md text-sm focus:ring-camel focus:border-camel"></textarea>
                        </div>
                        <button type="button" @click="send()"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-md bg-[#25D366] text-white font-semibold text-sm hover:bg-[#1EBE5A] transition shadow-sm">
                            Send via WhatsApp
                        </button>
                        <p class="text-[11px] text-charcoal-soft text-center">You'll be redirected to WhatsApp with your
                            message pre-filled.</p>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Related --}}
        @if($related->count())
            <div class="mt-16 pt-10 border-t border-stone-line">
                <h2 class="text-2xl font-semibold text-charcoal mb-6">Other properties in {{ $property->country?->name }}</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                        <x-property-card :property="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

    </x-section>

@endsection