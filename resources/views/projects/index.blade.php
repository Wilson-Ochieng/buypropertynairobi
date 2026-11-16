@extends('layouts.app')
@section('title', 'Projects — Nanchong Group')
@section('content')

    <x-section eyebrow="Our Portfolio" title="Projects">

        {{-- ============== COUNTRY TABS ============== --}}
        <div class="flex flex-wrap gap-2 mb-6 border-b border-stone-line pb-4">
            @php
                $baseFilters = request()->except(['country', 'page']);   // drop country + page
            @endphp

            <a href="{{ route('projects.index', array_filter($baseFilters, fn($v) => $v !== null && $v !== '')) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition
                      {{ !$activeCountry
        ? 'bg-camel text-charcoal'
        : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                All countries
            </a>

            @foreach($countries as $country)
                    <a href="{{ route('projects.index', array_merge(
                    array_filter($baseFilters, fn($v) => $v !== null && $v !== ''),
                    ['country' => $country->slug]
                )) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition
                                          {{ $activeCountry?->id === $country->id
                    ? 'bg-camel text-charcoal'
                    : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                        {{ $country->name }}
                    </a>
            @endforeach
        </div>
        {{-- ============== Buy / Rent / All ============== --}}
        <div class="flex gap-2 mb-4">
            <span class="text-xs uppercase tracking-wider font-semibold text-charcoal-soft py-2">Purpose:</span>
            @foreach(['' => 'All', 'buy' => 'Buy', 'rent' => 'Rent'] as $val => $label)
                @php
                    $query = array_filter(
                        array_merge(request()->query(), ['purpose' => $val ?: null]),
                        fn($v) => $v !== null
                    );
                @endphp
                <a href="{{ route('projects.index', $query) }}" class="px-3 py-1.5 rounded-md text-sm font-medium transition
                                          {{ ($purpose ?? '') === $val
                ? 'bg-camel text-charcoal'
                : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- ============== FILTER FORM ============== --}}
        <form method="GET" action="{{ route('projects.index') }}"
            class="bg-white border border-stone-line rounded-lg p-5 mb-8">
            <input type="hidden" name="country" value="{{ $activeCountrySlug }}">

            {{-- TOP ROW — 5 columns: Location · Type · Bedrooms · Max price · Search button --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                {{-- Location --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Location
                    </label>
                    <select name="location"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                        <option value="">All locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc }}" @selected(request('location') === $loc)>{{ $loc }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Property type
                    </label>
                    <select name="type"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                        <option value="">All types</option>
                        <option value="residential" @selected(request('type') === 'residential')>Residential</option>
                        <option value="commercial" @selected(request('type') === 'commercial')>Commercial</option>
                    </select>
                </div>

                {{-- Bedrooms --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Bedrooms
                    </label>
                    <select name="bedrooms"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                        <option value="">Any</option>
                        <option value="1" @selected(request('bedrooms') == 1)>1+</option>
                        <option value="2" @selected(request('bedrooms') == 2)>2+</option>
                        <option value="3" @selected(request('bedrooms') == 3)>3+</option>
                        <option value="4" @selected(request('bedrooms') == 4)>4+</option>
                    </select>
                </div>

                {{-- Max price --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Max price (KES)
                    </label>
                    <input type="number" name="max_price" step="100000" min="0" value="{{ request('max_price') }}"
                        placeholder="e.g. 10,000,000"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                </div>


                {{-- Status --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">
                        Status
                    </label>
                    <select name="status"
                        class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel text-sm">
                        <option value="">Any status</option>
                        <option value="ongoing" @selected(request('status') === 'ongoing')>Ongoing</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                        <option value="off_plan" @selected(request('status') === 'off_plan')>Off-Plan</option>
                    </select>
                </div>

                {{-- Search projects button --}}
                <div>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-md bg-camel text-charcoal font-semibold text-sm hover:bg-dusty-taupe hover:text-cream transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                        Search projects
                    </button>
                </div>
            </div>

            {{-- SECONDARY ROW — small Reset link --}}
            <div class="mt-4 flex items-center justify-between text-xs text-charcoal-soft">
                <div>
                    @if(request()->hasAny(['location', 'type', 'bedrooms', 'max_price']))
                        Filters applied.
                    @endif
                </div>
                <a href="{{ route('projects.index', ['country' => $activeCountrySlug]) }}"
                    class="text-camel hover:text-dusty-taupe underline underline-offset-2">
                    Reset filters
                </a>
            </div>
        </form>

        {{-- ============== RESULTS ============== --}}
        @if($projects->isEmpty())
            <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                No projects match your filters.
                <a href="{{ route('projects.index', $activeCountrySlug ? ['country' => $activeCountrySlug] : []) }}"
                    class="text-camel underline ml-1">Reset filters</a>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        @endif

    </x-section>

@endsection