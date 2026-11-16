@props(['unit'])

@php
    $project = $unit->project;
    $image = $unit->images->first();
    $href = route('units.show', $unit);

    $price = $unit->price_kes
        ? 'KES ' . number_format((float) $unit->price_kes, 0)
        : 'Price on request';

    $whatsapp = 'https://wa.me/' . ($project?->whatsapp ?? '254710998888')
        . '?text=' . urlencode("Hi, I'm interested in the {$unit->name} at {$project?->name}.");

    $bedroomsLabel = $unit->bedrooms !== null
        ? match ((int) $unit->bedrooms) {
            0 => 'Studio',
            1 => '1 Bed',
            2 => '2 Bed',
            3 => '3 Bed',
            4 => '4+ Bed',
            default => $unit->bedrooms . ' Bed',
        }
        : null;

    $sizeLabel = null;
    if ($unit->size_min_sqm) {
        $sizeLabel = (int) $unit->size_min_sqm;
        if ($unit->size_max_sqm && $unit->size_max_sqm != $unit->size_min_sqm) {
            $sizeLabel .= '–' . (int) $unit->size_max_sqm;
        }
        $sizeLabel .= ' m²';
    }
@endphp

<article
    class="bg-white border border-stone-line rounded-lg overflow-hidden group flex flex-col transition hover:shadow-lg">

    {{-- Image with overlays --}}
    <a href="{{ $href }}" class="block aspect-[4/3] bg-ash-grey overflow-hidden relative">
        @if($image)
            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $unit->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        @elseif($project?->cover_image)
            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $unit->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
            </div>
        @endif

        {{-- Price chip --}}
        <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md shadow-lg"
            style="background-image: linear-gradient(135deg, #9B897A 0%, #C09C7A 55%, #C9A14A 100%);">
            <svg class="w-3.5 h-3.5 text-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-bold text-charcoal tracking-tight">{{ $price }}</span>
        </div>

        {{-- Purpose badge --}}
        @if($unit->purpose)
            <div class="absolute top-3 right-3">
                <span class="px-2 py-1 rounded text-[10px] font-semibold uppercase tracking-wider shadow
                                 {{ $unit->purpose === 'rent' ? 'bg-camel text-charcoal' : 'bg-charcoal text-cream' }}">
                    {{ $unit->purpose === 'rent' ? 'Rent' : 'Sale' }}
                </span>
            </div>
        @endif
    </a>

    {{-- Body --}}
    <div class="p-5 flex-1 flex flex-col">

        {{-- Location + country --}}
        <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">
            {{ $project?->country?->name }}{{ $project?->location ? ' · ' . $project->location : '' }}
        </div>

        {{-- Unit name + lookup --}}
        <h3 class="text-lg font-semibold text-charcoal mb-1">
            {{ $unit->name }}
            @if($unit->unitTypeLookup)
                <span class="text-xs font-normal text-charcoal-soft">
                    · {{ $unit->unitTypeLookup->name }}
                </span>
            @endif
        </h3>

        {{-- Project link --}}
        @if($project)
            <a href="{{ route('projects.show', $project) }}"
                class="text-xs text-charcoal-soft hover:text-camel transition mb-3 inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                {{ $project->name }}
            </a>
        @endif

        {{-- Price + negotiable --}}
        <div class="flex items-baseline justify-between mb-3">
            <div class="text-lg font-bold text-charcoal">{{ $price }}</div>
            @if($unit->price_negotiable)
                <span class="text-xs text-charcoal-soft italic">Negotiable</span>
            @endif
        </div>

        {{-- Specs --}}
        <div class="grid grid-cols-3 gap-2 text-xs">
            @if($bedroomsLabel)
                <div>
                    <div class="text-camel uppercase tracking-wider mb-0.5">Bedrooms</div>
                    <div class="font-medium text-charcoal">{{ $bedroomsLabel }}</div>
                </div>
            @endif

            @if($sizeLabel)
                <div>
                    <div class="text-camel uppercase tracking-wider mb-0.5">Size</div>
                    <div class="font-medium text-charcoal">{{ $sizeLabel }}</div>
                </div>
            @endif

            @if($unit->style)
                <div>
                    <div class="text-camel uppercase tracking-wider mb-0.5">Style</div>
                    <div class="font-medium text-charcoal">{{ $unit->style->name }}</div>
                </div>
            @endif
        </div>

        {{-- Amenity chips --}}
        @if(!empty($unit->features))
            <div class="mt-3 pt-3 border-t border-stone-line">
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($unit->features, 0, 3) as $feature)
                        <span class="px-2 py-0.5 rounded bg-cream text-xs text-charcoal-soft">{{ $feature }}</span>
                    @endforeach
                    @if(count($unit->features) > 3)
                        <span class="px-2 py-0.5 rounded bg-cream text-xs text-camel font-medium">
                            +{{ count($unit->features) - 3 }} more
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- CTAs --}}
    <div class="px-5 pb-5 pt-3 border-t border-stone-line flex gap-2">
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener"
            class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-md bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1EBE5A] transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            WhatsApp
        </a>
        <a href="{{ $href }}"
            class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-md bg-camel text-charcoal text-sm font-semibold hover:bg-dusty-taupe hover:text-cream transition">
            View details
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</article>