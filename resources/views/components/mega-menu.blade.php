@props(['menu'])

@php
    $linkClass = 'flex items-center justify-between text-sm text-charcoal-soft hover:text-camel hover:bg-cream px-2 py-1 rounded transition';
    $headingClass = 'text-[11px] uppercase tracking-wider font-semibold text-camel mb-2';
@endphp

@if(!empty($menu['has_data']))
    <div class="px-6 py-5">
        <div class="flex flex-wrap gap-x-8 gap-y-6 items-start">

            {{-- LOCATION --}}
            @if(!empty($menu['locations']))
                <div class="flex-1 min-w-[160px]">
                    <div class="{{ $headingClass }}">Location</div>
                    <ul class="space-y-0.5">
                        @foreach($menu['locations'] as $name => $count)
                            <li>
                               <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => Str::slug($name), 'by' => 'location']) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $name }}</span>
                                    <span class="text-xs text-charcoal-soft/60 ml-2">{{ $count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- USE --}}
            @if(!empty($menu['uses']))
                <div class="flex-1 min-w-[160px]">
                    <div class="{{ $headingClass }}">Use</div>
                    <ul class="space-y-0.5">
                        @foreach($menu['uses'] as $slug => $data)
                            <li>
                               <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => Str::slug($data['name']), 'by' => 'use']) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $data['name'] }}</span>
                                    <span class="text-xs text-charcoal-soft/60 ml-2">{{ $data['count'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- STYLE (with inline bedroom breakdown) --}}
            @if(!empty($menu['styles']))
                <div class="flex-1 min-w-[160px]">
                    <div class="{{ $headingClass }}">Style</div>
                    <ul class="space-y-0.5">
                        @foreach($menu['styles'] as $style)
                            @php $styleSlug = $style['slug'] ?? Str::slug($style['name']); @endphp
                            <li class="group">
                               <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => $styleSlug, 'by' => 'style']) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $style['name'] }}</span>
                                    <span class="flex items-center gap-1 ml-2 text-xs text-charcoal-soft/60">
                                        {{ $style['count'] }}
                                        @if($style['flyout'])
                                            <svg class="w-3 h-3 transition-transform group-hover:rotate-90 group-focus-within:rotate-90"
                                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        @endif
                                    </span>
                                </a>

                                @if($style['flyout'])
                                    <ul
                                        class="hidden group-hover:block group-focus-within:block ml-3 mt-0.5 mb-1 pl-2 border-l border-camel/30 space-y-0.5">
                                        <li>
                                            <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => $styleSlug]) }}"
                                                class="{{ $linkClass }} !text-xs">
                                                <span>Any {{ $style['name'] }}</span>
                                                <span class="text-charcoal-soft/60 ml-2">{{ $style['count'] }}</span>
                                            </a>
                                        </li>
                                        @foreach($style['bedrooms'] as $bed)
                                            <li>
                                                <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => $styleSlug, 'bedrooms' => $bed['value']]) }}"
                                                    class="{{ $linkClass }} !text-xs">
                                                    <span>{{ $bed['label'] }}</span>
                                                    <span class="text-charcoal-soft/60 ml-2">{{ $bed['count'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- BUDGET --}}
            @if(!empty($menu['budgets']))
                <div class="flex-1 min-w-[160px]">
                    <div class="{{ $headingClass }}">Budget</div>
                    <ul class="space-y-0.5">
                        @foreach($menu['budgets'] as $id => $data)
                            <li>
                               <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => $data['slug'], 'by' => 'budget']) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $data['label'] }}</span>
                                    <span class="text-xs text-charcoal-soft/60 ml-2">{{ $data['count'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TYPE --}}
            @if(!empty($menu['types']))
                <div class="flex-1 min-w-[160px]">
                    <div class="{{ $headingClass }}">Type</div>
                    <ul class="space-y-0.5">
                        @foreach($menu['types'] as $data)
                            <li>
                               <a href="{{ route('category-pages.show', ['purpose' => $menu['purpose'], 'slug' => $data['slug'] ?? Str::slug($data['name']), 'by' => 'type']) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $data['name'] }}</span>
                                    <span class="text-xs text-charcoal-soft/60 ml-2">{{ $data['count'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="px-6 py-12 text-center">
        <div class="text-sm text-charcoal-soft italic">
          No properties {{ $menu['purpose'] === 'buy' ? 'for sale' : 'for rent' }} yet.
        </div>
        <p class="text-xs text-charcoal-soft/60 mt-2">
            Listings will appear here as soon as they are added.
        </p>
    </div>
@endif