@props(['property'])

@php
    $cover = $property->cover_image ? asset('storage/' . $property->cover_image) : null;
    $price = $property->price_label;
    $statusColors = [
        'available' => 'bg-emerald-dark/90 text-cream',
        'off_plan' => 'bg-gold-dark/95 text-white',
        'under_construction' => 'bg-gold-dark/95 text-white',
        'sold' => 'bg-ink/85 text-cream',
        'rented' => 'bg-ink/85 text-cream',
    ];
@endphp

<a href="{{ route('properties.show', $property) }}"
    class="group flex flex-col overflow-hidden rounded-xl border border-border-soft bg-white shadow-sm transition duration-300 hover:border-gold/60 hover:shadow-xl motion-safe:hover:-translate-y-1">

    {{-- Image --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-emerald-dark">
        @if($cover)
            <img src="{{ $cover }}" alt="{{ $property->title }}" loading="lazy"
                class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-emerald-dark to-emerald">
                <span class="font-serif text-4xl text-gold/60" aria-hidden="true">▥</span>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent" aria-hidden="true"></div>

        <div class="absolute left-3 top-3 flex gap-2">
            <span class="rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-wider backdrop-blur {{ $statusColors[$property->status] ?? 'bg-emerald-dark/90 text-cream' }}">
                {{ $property->status_label }}
            </span>
            @if($property->purpose === 'rent')
                <span class="rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider text-ink">For Rent</span>
            @endif
        </div>

        <div class="absolute bottom-3 left-4 right-4">
            <div class="font-serif text-xl font-semibold text-white drop-shadow">{{ $price['label'] }}</div>
        </div>
    </div>

    {{-- Details --}}
    <div class="flex flex-1 flex-col p-5">
        <div class="mb-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-gold-dark">
            {{ $property->location }}@if($property->city), {{ $property->city }}@endif
        </div>
        <h3 class="mb-4 font-serif text-lg font-semibold leading-snug text-ink transition-colors group-hover:text-gold-dark line-clamp-2">
            {{ $property->title }}
        </h3>

        <div class="mt-auto flex items-center gap-4 border-t border-border-soft pt-4 text-sm text-muted">
            @if($property->bedrooms !== null)
                <span class="inline-flex items-center gap-1.5"><span class="font-semibold text-ink">{{ $property->bedrooms }}</span> Beds</span>
            @endif
            @if($property->bathrooms !== null)
                <span class="inline-flex items-center gap-1.5"><span class="font-semibold text-ink">{{ $property->bathrooms }}</span> Baths</span>
            @endif
            @if($property->size_sqm)
                <span class="inline-flex items-center gap-1.5"><span class="font-semibold text-ink">{{ rtrim(rtrim(number_format($property->size_sqm, 1), '0'), '.') }}</span> m²</span>
            @endif
        </div>
    </div>
</a>