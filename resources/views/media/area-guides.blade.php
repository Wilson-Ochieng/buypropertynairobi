@extends('layouts.app')
@section('title', 'Area Guides — Nanchong Group')
@section('content')
    <x-section eyebrow="Media" title="Area Guides" subtitle="Neighbourhood guides for the locations where we build.">
        @if($guides->isEmpty())
            <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                Area guides are being prepared. Check back soon.
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($guides as $insight)
                    <a href="{{ route('media.area-guides.show', $insight) }}" class="card group">
                        <div class="aspect-[16/9] bg-ash-grey overflow-hidden">
                            @if($insight->cover_image)
                                <img src="{{ asset('storage/' . $insight->cover_image) }}" alt="{{ $insight->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                                    <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">{{ $insight->location }}
                            </div>
                            <h3 class="text-lg font-semibold text-charcoal mb-2 group-hover:text-camel transition">
                                {{ $insight->title }}</h3>
                            @if($insight->summary)
                            <p class="text-sm text-charcoal-soft">{{ Str::limit($insight->summary, 120) }}</p>@endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </x-section>
@endsection