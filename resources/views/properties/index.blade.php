@extends('layouts.app')
@section('title', 'Properties — Buy Property Nairobi')

@section('content')

<x-section eyebrow="Browse" title="Properties">

    {{-- Country tabs --}}
    <div class="flex flex-wrap gap-2 mb-6 border-b border-stone-line pb-4">
        @php $baseFilters = request()->except(['country', 'page']); @endphp

        <a href="{{ route('properties.index', array_filter($baseFilters, fn ($v) => $v !== null && $v !== '')) }}"
           class="px-4 py-2 rounded-md text-sm font-medium transition {{ !$activeCountry ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
            All countries
        </a>

        @foreach($countries as $country)
            <a href="{{ route('properties.index', array_merge(
                    array_filter($baseFilters, fn ($v) => $v !== null && $v !== ''),
                    ['country' => $country->slug]
                )) }}"
               class="px-4 py-2 rounded-md text-sm font-medium transition {{ $activeCountry?->id === $country->id ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                {{ $country->name }}
            </a>
        @endforeach
    </div>

    {{-- Purpose tabs --}}
    <div class="flex gap-2 mb-4">
        <span class="text-xs uppercase tracking-wider font-semibold text-charcoal-soft py-2">Purpose:</span>
        @foreach(['' => 'All', 'sale' => 'Buy', 'rent' => 'Rent'] as $val => $label)
            @php
                $query = array_filter(
                    array_merge(request()->query(), ['purpose' => $val ?: null]),
                    fn ($v) => $v !== null
                );
            @endphp
            <a href="{{ route('properties.index', $query) }}"
               class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ ($purpose ?? '') === $val ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('properties.index') }}"
          class="bg-white border border-stone-line rounded-lg p-5 mb-8">
        <input type="hidden" name="country" value="{{ $activeCountrySlug }}">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Location</label>
                <select name="location" class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    <option value="">All locations</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" @selected(request('location') === $loc)>{{ $loc }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Category</label>
                <select name="category" class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    <option value="">All</option>
                    <option value="residential" @selected(request('category') === 'residential')>Residential</option>
                    <option value="commercial" @selected(request('category') === 'commercial')>Commercial</option>
                    <option value="land" @selected(request('category') === 'land')>Land</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Bedrooms</label>
                <select name="bedrooms" class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                    <option value="">Any</option>
                    @foreach([1, 2, 3, 4, 5] as $n)
                        <option value="{{ $n }}" @selected(request('bedrooms') == $n)>{{ $n }}+</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Max price (KES)</label>
                <input type="number" name="max_price" step="100000" min="0" value="{{ request('max_price') }}"
                    placeholder="e.g. 10,000,000"
                    class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
            </div>

            <div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-md bg-camel text-charcoal font-semibold text-sm hover:bg-dusty-taupe hover:text-cream transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    Search properties
                </button>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between text-xs text-charcoal-soft">
            <div>
                @if(request()->hasAny(['location', 'category', 'bedrooms', 'max_price', 'purpose']))
                    Filters applied.
                @endif
            </div>
            <a href="{{ route('properties.index', ['country' => $activeCountrySlug]) }}"
                class="text-camel hover:text-dusty-taupe underline underline-offset-2">
                Reset filters
            </a>
        </div>
    </form>

    {{-- Results --}}
    @if($properties->isEmpty())
        <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
            No properties match your filters.
            <a href="{{ route('properties.index') }}" class="text-camel underline ml-1">Reset filters</a>
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>

        <div class="mt-10">
            {{ $properties->links() }}
        </div>
    @endif

</x-section>

@endsection