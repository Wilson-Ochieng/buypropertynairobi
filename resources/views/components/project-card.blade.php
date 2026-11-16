@props(['project'])

@php
    $href     = route('projects.show', $project);
    $whatsapp = $project->whatsapp_url;
    $price    = $project->price_summary;
    $hasSale  = $project->unitTypes->whereIn('purpose', ['sale','both'])->isNotEmpty();
    $hasRent  = $project->unitTypes->whereIn('purpose', ['rent','both'])->isNotEmpty();
    $videoCount = $project->videos->count();
@endphp

<article class="card group flex flex-col">
    <a href="{{ $href }}" class="block">
        <div class="aspect-[4/3] bg-ash-grey overflow-hidden relative">
            @if($project->cover_image)
                <img src="{{ asset('storage/' . $project->cover_image) }}"
                     alt="{{ $project->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center text-charcoal-soft">
                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M15 9h.01M9 13h.01M15 13h.01M9 17h.01M15 17h.01"/>
                    </svg>
                </div>
            @endif

            {{-- Price chip --}}
            <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-md shadow-lg"
                 style="background-image: linear-gradient(135deg, #9B897A 0%, #C09C7A 55%, #C9A14A 100%);">
                <svg class="w-3.5 h-3.5 text-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-bold text-charcoal tracking-tight">
                    {{ $price['label'] }}
                </span>
            </div>

            {{-- Status badges (top-right) --}}
            <div class="absolute top-3 right-3 flex flex-col items-end gap-1.5">
                @if($videoCount > 0)
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-[10px] font-semibold uppercase tracking-wider bg-charcoal text-cream shadow"
                          title="{{ $videoCount }} video{{ $videoCount > 1 ? 's' : '' }}">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        {{ $videoCount }} Video{{ $videoCount > 1 ? 's' : '' }}
                    </span>
                @endif

                @if($hasSale)
                    <span class="px-2 py-1 rounded text-[10px] font-semibold uppercase tracking-wider bg-white/95 text-charcoal shadow">
                        Sale
                    </span>
                @endif
                @if($hasRent)
                    <span class="px-2 py-1 rounded text-[10px] font-semibold uppercase tracking-wider bg-camel text-charcoal shadow">
                        Rent
                    </span>
                @endif
            </div>
        </div>

        <div class="p-5 pb-3">
            @if($project->country)
                <div class="text-xs uppercase tracking-widest text-camel font-medium mb-1">
                    {{ $project->country->name }}{{ $project->location ? ' · ' . $project->location : '' }}
                </div>
            @endif
            <h3 class="text-lg font-semibold text-charcoal mb-2 group-hover:text-camel transition">
                {{ $project->name }}
            </h3>
            @if($project->address)
                <p class="text-sm text-charcoal-soft mb-3">{{ $project->address }}</p>
            @endif
            @if($project->highlights->count())
                <ul class="text-sm text-charcoal-soft space-y-1">
                    @foreach($project->highlights->take(2) as $h)
                        <li class="flex items-start gap-2">
                            <span class="text-camel mt-0.5">•</span>
                            <span>{{ $h->label }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </a>

    {{-- CTAs --}}
    <div class="mt-auto px-5 pb-5 pt-3 border-t border-stone-line flex gap-2">
        <a href="{{ $whatsapp }}"
           target="_blank" rel="noopener"
           class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-md bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1EBE5A] transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp
        </a>
        <a href="{{ $href }}"
           class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-md bg-camel text-charcoal text-sm font-semibold hover:bg-dusty-taupe hover:text-cream transition">
            View details
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</article>