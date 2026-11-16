@props(['title' => null, 'eyebrow' => null, 'subtitle' => null])

<section {{ $attributes->merge(['class' => 'section']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($eyebrow || $title || $subtitle)
            <div class="mb-10 md:mb-12 max-w-3xl">
                @if($eyebrow)
                    <div class="section-eyebrow">{{ $eyebrow }}</div>
                @endif
                @if($title)
                    <h2 class="section-heading">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="text-charcoal-soft">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        {{ $slot }}
    </div>
</section>