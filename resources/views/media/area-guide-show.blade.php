@extends('layouts.app')
@section('title', $insight->meta_title ?? $insight->title . ' — Nanchong Group')
@section('content')
    <x-section :eyebrow="$insight->location" :title="$insight->title">
        <div class="grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2">
                @if($insight->cover_image)
                    <img src="{{ asset('storage/' . $insight->cover_image) }}" alt="{{ $insight->title }}"
                        class="w-full rounded-lg mb-8">
                @endif
                @if($insight->summary)
                <p class="text-lg text-charcoal-soft italic mb-6">{{ $insight->summary }}</p>@endif
                <div class="prose prose-stone max-w-none text-charcoal-soft">{!! $insight->body !!}</div>
            </div>
            <aside>
                @if($relatedProjects->isNotEmpty())
                    <div class="bg-cream border border-stone-line rounded-lg p-6 sticky top-32">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-camel mb-4">
                            Properties in {{ $insight->location }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedProjects as $p)
                                <a href="{{ route('projects.show', $p) }}"
                                    class="block bg-white border border-stone-line rounded-md p-4 hover:border-camel transition">
                                    <div class="font-semibold text-charcoal">{{ $p->name }}</div>
                                    @if($p->address)
                                    <div class="text-xs text-charcoal-soft mt-1">{{ $p->address }}</div>@endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </x-section>
@endsection