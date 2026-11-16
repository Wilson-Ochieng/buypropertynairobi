@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title . ' — Nanchong Group')
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->body), 155))
@section('og_type', 'article')
@section('og_image', $post->cover_image ? asset('storage/' . $post->cover_image) : asset('images/logo.png'))

@section('content')

    {{-- JSON-LD Article Schema (built in plain PHP; "\x40" = "@" so Blade never parses the keys) --}}
    <?php
    $schema = [
        "\x40context" => 'https://schema.org',
        "\x40type" => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->body), 155),
        'datePublished' => $post->published_at?->toIso8601String() ?? $post->created_at?->toIso8601String(),
        'dateModified' => $post->updated_at?->toIso8601String(),
        'author' => [
            "\x40type" => 'Person',
            'name' => $post->author_name ?? 'Nanchong Group',
        ],
        'publisher' => [
            "\x40type" => 'Organization',
            'name' => 'Nanchong Group',
            'logo' => [
                "\x40type" => 'ImageObject',
                'url' => asset('images/logo.png'),
            ],
        ],
        'mainEntityOfPage' => [
            "\x40type" => 'WebPage',
            "\x40id" => url()->current(),
        ],
    ];
    if ($post->cover_image) {
        $schema['image'] = asset('storage/' . $post->cover_image);
    }
        ?>
    <script
        type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>

    {{-- Breadcrumbs --}}
    <div class="bg-cream border-b border-stone-line">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-charcoal-soft flex-wrap" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-camel transition">Home</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('media.blog') }}" class="hover:text-camel transition">Blog</a>
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-charcoal font-medium">{{ Str::limit($post->title, 50) }}</span>
            </nav>
        </div>
    </div>

    {{-- Article --}}
    <article class="py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Category + Date --}}
            <?php
    $wordCount = str_word_count(strip_tags($post->body ?? ''));
    $readingTime = max(1, ceil($wordCount / 200));
                ?>
            <div class="flex items-center gap-3 text-xs uppercase tracking-wider mb-4">
                @if($post->category)
                    <a href="{{ route('media.blog', ['category' => $post->category]) }}"
                        class="text-camel font-semibold hover:text-dusty-taupe">{{ $post->category }}</a>
                    <span class="text-charcoal-soft/40">·</span>
                @endif
                <time datetime="{{ $post->published_at?->toIso8601String() }}" class="text-charcoal-soft/70">
                    {{ $post->published_at?->format('F j, Y') }}
                </time>
                @if($post->author_name)
                    <span class="text-charcoal-soft/40">·</span>
                    <span class="text-charcoal-soft/70">{{ $post->author_name }}</span>
                @endif
                <span class="text-charcoal-soft/40">·</span>
                <span class="text-charcoal-soft/70">{{ $readingTime }} min read</span>
            </div>

            {{-- H1 --}}
            <h1 class="text-3xl md:text-5xl font-semibold text-charcoal leading-tight mb-6">
                {{ $post->title }}
            </h1>

            {{-- Excerpt --}}
            @if($post->excerpt)
                <p class="text-lg md:text-xl text-charcoal-soft italic mb-8 border-l-4 border-camel pl-4">
                    {{ $post->excerpt }}
                </p>
            @endif

            {{-- Cover image --}}
            @if($post->cover_image)
                <figure class="mb-10">
                    <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full rounded-lg">
                </figure>
            @endif

            {{-- Body --}}
            <div class="prose prose-stone prose-lg max-w-none text-charcoal-soft
                            prose-headings:text-charcoal prose-headings:font-semibold
                            prose-a:text-camel prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-lg">
                {!! $post->body !!}
            </div>

            {{-- Footer meta --}}
            <div class="mt-12 pt-6 border-t border-stone-line flex items-center justify-between flex-wrap gap-4">
                <div class="text-sm text-charcoal-soft">
                    Published {{ $post->published_at?->format('F j, Y') }}
                    @if($post->author_name)
                        · by <strong class="text-charcoal">{{ $post->author_name }}</strong>
                    @endif
                </div>
                <a href="{{ route('media.blog') }}" class="text-sm text-camel hover:text-dusty-taupe">
                    ← Back to Blog
                </a>
            </div>
        </div>
    </article>

    {{-- Related posts --}}
    @if($related->isNotEmpty())
        <x-section eyebrow="Keep Reading" title="More from the blog">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($related as $r)
                    <a href="{{ route('media.blog.show', $r) }}" class="card group flex flex-col">
                        <div class="aspect-[16/9] bg-ash-grey overflow-hidden">
                            @if($r->cover_image)
                                <img src="{{ asset('storage/' . $r->cover_image) }}" alt="{{ $r->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            @if($r->category)
                                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">{{ $r->category }}</div>
                            @endif
                            <h3 class="text-base font-semibold text-charcoal mb-2 group-hover:text-camel transition">
                                {{ $r->title }}
                            </h3>
                            <div class="mt-auto text-xs text-charcoal-soft/70">
                                {{ $r->published_at?->format('M j, Y') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </x-section>
    @endif

@endsection