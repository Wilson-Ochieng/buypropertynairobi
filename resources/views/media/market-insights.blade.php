@extends('layouts.app')
@section('title', 'Market Insights — Nanchong Group')
@section('content')
<x-section eyebrow="Media" title="Market Insights"
    subtitle="Data, analysis, and commentary on the property market.">
    @if($insights->isEmpty())
        <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
            No insights yet. Check back soon.
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($insights as $insight)
                <a href="{{ route('media.market-insights.show', $insight) }}" class="card group">
                    <div class="aspect-[16/9] bg-ash-grey overflow-hidden">
                        @if($insight->cover_image)
                            <img src="{{ asset('storage/' . $insight->cover_image) }}" alt="{{ $insight->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">Market Insight</div>
                        <h3 class="text-lg font-semibold text-charcoal mb-2 group-hover:text-camel transition">{{ $insight->title }}</h3>
                        @if($insight->summary)<p class="text-sm text-charcoal-soft">{{ Str::limit($insight->summary, 120) }}</p>@endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-section>
@endsection