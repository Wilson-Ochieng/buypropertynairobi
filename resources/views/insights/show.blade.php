@extends('layouts.app')
@section('title', $insight->meta_title ?? $insight->title . ' — Nanchong Group')
@section('meta_description', $insight->meta_description ?? $insight->summary)

@section('content')
<x-section :eyebrow="$insight->location" :title="$insight->title">
    <div class="grid lg:grid-cols-3 gap-10">

        {{-- Main content --}}
        <div class="lg:col-span-2">
            @if($insight->cover_image)
                <img src="{{ asset('storage/' . $insight->cover_image) }}"
                     alt="{{ $insight->title }}"
                     class="w-full rounded-lg mb-8">
            @endif

            @if($insight->summary)
                <p class="text-lg text-charcoal-soft italic mb-6">{{ $insight->summary }}</p>
            @endif

            <div class="prose prose-stone max-w-none text-charcoal-soft leading-relaxed">
                {!! $insight->body !!}
            </div>
        </div>

        {{-- Sidebar: projects in this location --}}
        <aside class="lg:col-span-1">
            @if($relatedProjects->isNotEmpty())
                <div class="bg-cream border border-stone-line rounded-lg p-6 sticky top-32">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-camel mb-4">
                        Properties in {{ $insight->location }}
                    </h3>
                    <div class="space-y-4">
                        @foreach($relatedProjects as $project)
                            <a href="{{ route('projects.show', $project) }}"
                               class="block bg-white border border-stone-line rounded-md p-4 hover:border-camel transition">
                                <div class="font-semibold text-charcoal">{{ $project->name }}</div>
                                @if($project->country)
                                    <div class="text-xs text-charcoal-soft mt-1">{{ $project->country->name }}</div>
                                @endif
                                @if($project->highlights->count())
                                    <div class="text-xs text-charcoal-soft mt-2">
                                        {{ $project->highlights->first()->label }}
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('projects.index') }}"
                       class="block mt-4 text-sm text-camel hover:text-dusty-taupe">
                        View all projects →
                    </a>
                </div>
            @endif
        </aside>
    </div>

    {{-- Other insights --}}
    @if($otherInsights->isNotEmpty())
        <div class="mt-16 pt-10 border-t border-stone-line">
            <h3 class="text-xl font-semibold text-charcoal mb-6">More insights</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($otherInsights as $other)
                    <a href="{{ route('insights.show', $other) }}"
                       class="bg-white border border-stone-line rounded-lg p-5 hover:border-camel transition">
                        <div class="text-xs uppercase tracking-widest text-camel mb-1">{{ $other->location }}</div>
                        <div class="font-semibold text-charcoal">{{ $other->title }}</div>
                        @if($other->summary)
                            <div class="text-sm text-charcoal-soft mt-2">{{ Str::limit($other->summary, 100) }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-section>
@endsection