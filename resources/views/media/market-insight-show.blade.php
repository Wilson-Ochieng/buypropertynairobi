@extends('layouts.app')
@section('title', $insight->meta_title ?? $insight->title . ' — Nanchong Group')
@section('content')
    <x-section eyebrow="Market Insight" :title="$insight->title">
        <div class="max-w-3xl">
            @if($insight->cover_image)
                <img src="{{ asset('storage/' . $insight->cover_image) }}" alt="{{ $insight->title }}"
                    class="w-full rounded-lg mb-8">
            @endif
            @if($insight->summary)
            <p class="text-lg text-charcoal-soft italic mb-6">{{ $insight->summary }}</p>@endif
            <div class="prose prose-stone max-w-none text-charcoal-soft">{!! $insight->body !!}</div>
        </div>
    </x-section>
@endsection