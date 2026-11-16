@extends('layouts.app')
@section('title', 'Insights — Nanchong Group')
@section('content')

    <x-section eyebrow="Guides & Market Notes" title="Insights">
        <p class="text-charcoal-soft max-w-2xl mb-8">
            Location guides, market notes, and buying advice for the neighbourhoods where we build.
        </p>

        {{-- Location filter --}}
        @if($locations->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-8 border-b border-stone-line pb-4">
                <a href="{{ route('insights.index') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition
                                                      {{ !request('location') ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                    All
                </a>
                @foreach($locations as $loc)
                    <a href="{{ route('insights.index', ['location' => $loc]) }}"
                        class="px-4 py-2 rounded-md text-sm font-medium transition
                                                                          {{ request('location') === $loc ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                        {{ $loc }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($insights->isEmpty())
            <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                No insights yet. Check back soon.
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($insights as $insight)
                    <article class="card group">
                        <a href="{{ route('insights.show', $insight) }}" class="block">
                            <div class="aspect-[16/9] bg-ash-grey overflow-hidden">
                                @if($insight->cover_image)
                                    <img src="{{ asset('storage/' . $insight->cover_image) }}" alt="{{ $insight->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                                        <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">
                                    {{ $insight->location }}
                                </div>
                                <h3 class="text-lg font-semibold text-charcoal mb-2 group-hover:text-camel transition">
                                    {{ $insight->title }}
                                </h3>
                                @if($insight->summary)
                                    <p class="text-sm text-charcoal-soft">{{ Str::limit($insight->summary, 120) }}</p>
                                @endif
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    </x-section>
@endsection