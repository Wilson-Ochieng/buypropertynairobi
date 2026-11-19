@extends('layouts.app')

@section('title', $page->meta_title ?? $page->h1 . ' — Buy Property Nairobi')
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->description ?? ''), 155))

@php
    // Base slug without any bedroom suffix (override pages may be "apartment/2-bedroom")
    $baseSlug = Str::before($page->slug, '/');
    $byHint = request('by') ?: $page->category_type;

    // Link to this category with an optional bedroom filter, keeping the "by" hint
    $categoryUrl = function ($bedroomValue = null) use ($purpose, $baseSlug, $byHint) {
        return route('category-pages.show', array_filter([
            'purpose' => $purpose,
            'slug' => $baseSlug,
            'by' => $byHint,
            'bedrooms' => $bedroomValue,
        ], fn($v) => $v !== null && $v !== ''));
    };

    $bedroomOptions = [
        0 => 'Studio',
        1 => '1 Bed',
        2 => '2 Bed',
        3 => '3 Bed',
        4 => '4+ Bed',
    ];
@endphp

@section('content')

    {{-- Breadcrumbs --}}
    <div class="bg-cream-warm border-b border-border-soft">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-muted flex-wrap" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-gold-dark transition">Home</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('projects.index', ['purpose' => $purpose]) }}" class="hover:text-gold-dark transition">
                    {{ $purpose === 'buy' ? 'Buy' : 'Rent' }}
                </a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                @if($bedrooms !== null)
                    <a href="{{ $categoryUrl() }}" class="hover:text-gold-dark transition">
                        {{ ucfirst(str_replace(['-', '_'], ' ', $page->filter_value ?: $baseSlug)) }}
                    </a>
                    <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-ink font-medium">{{ $page->h1 }}</span>
                @else
                    <span class="text-ink font-medium">{{ $page->h1 }}</span>
                @endif
            </nav>
        </div>
    </div>

    <x-section>
        {{-- Hero --}}
        <div class="max-w-4xl mb-10">
            <div class="text-sm uppercase tracking-widest text-gold-dark mb-2">
                {{ $purpose === 'buy' ? 'Buy' : 'Rent' }} · {{ ucfirst($page->category_type) }}
            </div>
            <h1 class="text-3xl md:text-4xl font-serif font-semibold text-ink mb-4">{{ $page->h1 }}</h1>

            @if($page->description)
                <div class="prose prose-stone max-w-none text-ink-soft leading-relaxed">
                    {!! $page->description !!}
                </div>
            @endif
        </div>

        {{-- Bedroom filter --}}
        <div class="mb-6 flex items-center gap-2 flex-wrap">
            <span class="text-xs uppercase tracking-wider font-semibold text-gold-dark mr-1">Bedrooms</span>

            <a href="{{ $categoryUrl() }}" class="px-3 py-1.5 rounded-full text-sm border transition
                        {{ $bedrooms === null
        ? 'bg-emerald text-cream border-emerald'
        : 'bg-white text-muted border-border-soft hover:border-gold hover:text-gold-dark' }}">
                Any
            </a>

            @foreach($bedroomOptions as $value => $label)
                <a href="{{ $categoryUrl($value) }}" class="px-3 py-1.5 rounded-full text-sm border transition
                                {{ $bedrooms === $value
                ? 'bg-emerald text-cream border-emerald'
                : 'bg-white text-muted border-border-soft hover:border-gold hover:text-gold-dark' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Result summary --}}
        <div class="mb-6 flex items-center justify-between border-b border-border-soft pb-3 flex-wrap gap-2">
            <h2 class="text-lg font-semibold text-ink">
                {{ $totalUnits }} {{ Str::plural('unit', $totalUnits) }}
                @if($units->count() > 0)
                    across {{ $units->count() }} {{ Str::plural('project', $units->count()) }}
                @endif
            </h2>
            <a href="{{ route('projects.index', ['purpose' => $purpose]) }}"
                class="text-sm text-gold-dark hover:text-gold transition">
                See all {{ $purpose === 'buy' ? 'for sale' : 'rentals' }} →
            </a>
        </div>

        {{-- Empty state --}}
        @if($units->isEmpty())
            <div class="bg-cream-warm border border-border-soft rounded-lg p-10 text-center text-muted">
                <p class="mb-4">No matching units currently available.</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    @if($bedrooms !== null)
                        <a href="{{ $categoryUrl() }}" class="btn-secondary text-sm">Show all bedroom counts</a>
                    @endif
                    <a href="{{ route('projects.index', ['purpose' => $purpose]) }}" class="btn-secondary text-sm">
                        Browse all {{ $purpose === 'buy' ? 'for sale' : 'rentals' }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn-primary text-sm">Contact us</a>
                </div>
            </div>
        @else
            <div class="space-y-12">
                @foreach($units as $projectId => $projectUnits)
                    @php
                        $project = $projectUnits->first()->project;
                    @endphp
                    <div>
                        {{-- Project header --}}
                        <div class="flex items-start justify-between gap-4 mb-5 pb-3 border-b border-border-soft">
                            <div class="flex items-start gap-3">
                                @if($project?->cover_image)
                                    <a href="{{ route('projects.show', $project) }}" class="shrink-0">
                                        <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }}"
                                            class="w-16 h-16 rounded-md object-cover">
                                    </a>
                                @endif
                                <div>
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-lg font-serif font-semibold text-ink hover:text-gold-dark transition">
                                        {{ $project?->name }}
                                    </a>
                                    @if($project?->address)
                                        <p class="text-sm text-muted">{{ $project->address }}</p>
                                    @endif
                                    <p class="text-xs text-muted mt-1">
                                        {{ $projectUnits->count() }} {{ Str::plural('unit', $projectUnits->count()) }} available
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('projects.show', $project) }}"
                                class="text-xs font-medium text-gold-dark hover:text-gold whitespace-nowrap">
                                View project →
                            </a>
                        </div>

                        {{-- Unit cards --}}
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($projectUnits as $unit)
                                <x-unit-card :unit="$unit" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Related categories --}}
        @if($related->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-border-soft">
                <h3 class="text-lg font-semibold text-ink mb-4">Related categories</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($related as $rel)
                            <a href="{{ route('category-pages.show', [
                            'purpose' => $rel->purpose,
                            'slug' => $rel->slug,
                            'by' => $rel->category_type,
                        ]) }}"
                                class="px-4 py-2 rounded-md bg-cream-warm text-muted hover:bg-gold hover:text-white transition text-sm">
                                {{ $rel->h1 }}
                            </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-16 bg-emerald text-cream rounded-lg p-8 md:p-10 text-center">
            <h3 class="text-2xl font-serif font-semibold mb-3">Can't find what you're looking for?</h3>
            <p class="text-cream/75 mb-6 max-w-2xl mx-auto">
                Tell us what you need — our team will match you with the right property.
            </p>
            <a href="{{ route('contact') }}" class="btn-primary">Talk to our team</a>
        </div>
    </x-section>

@endsection