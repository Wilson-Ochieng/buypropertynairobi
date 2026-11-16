@extends('layouts.app')

@section('title', 'Blog — Nanchong Group')
@section('meta_description', 'News, market updates, and insights from Nanchong Group — building homes for love, quality Nanchong.')
@section('og_type', 'website')

@section('content')

{{-- BREADCRUMBS --}}
<div class="bg-cream border-b border-stone-line">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-charcoal-soft flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-camel transition">Home</a>
            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('media.blog') }}" class="text-charcoal font-medium">Blog</a>
        </nav>
    </div>
</div>

<x-section eyebrow="Media" title="Blog"
    subtitle="News, market updates, and stories from Nanchong Group.">

    {{-- Category filter --}}
    @if($categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('media.blog') }}"
               class="px-4 py-2 rounded-md text-sm font-medium transition
                      {{ !request('category') ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('media.blog', ['category' => $cat]) }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition
                          {{ request('category') === $cat ? 'bg-camel text-charcoal' : 'bg-cream text-charcoal-soft hover:bg-ash-grey/50' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    @endif

    @if($posts->isEmpty())
        <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
            No posts match your filter. <a href="{{ route('media.blog') }}" class="text-camel underline">Clear filter</a>
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <a href="{{ route('media.blog.show', $post) }}" class="card group flex flex-col">
                    <div class="aspect-[16/9] bg-ash-grey overflow-hidden">
                        @if($post->cover_image)
                            <img src="{{ asset('storage/' . $post->cover_image) }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                                <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        @if($post->category)
                            <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">{{ $post->category }}</div>
                        @endif
                        <h2 class="text-lg font-semibold text-charcoal mb-2 group-hover:text-camel transition">
                            {{ $post->title }}
                        </h2>
                        @if($post->excerpt)
                            <p class="text-sm text-charcoal-soft mb-3">{{ Str::limit($post->excerpt, 130) }}</p>
                        @endif
                        <div class="mt-auto flex items-center gap-2 text-xs text-charcoal-soft/70">
                            <time datetime="{{ $post->published_at?->toIso8601String() }}">
                                {{ $post->published_at?->format('M j, Y') }}
                            </time>
                            @if($post->author_name)
                                <span>·</span>
                                <span>{{ $post->author_name }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif
    @endif

</x-section>

@endsection