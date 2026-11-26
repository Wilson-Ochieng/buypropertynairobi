@props(['menu'])

@php
    $purpose = $menu['purpose'];
    $linkClass = 'flex items-center justify-between text-sm text-muted hover:text-gold-dark hover:bg-cream px-2 py-1.5 rounded transition';
    $headingClass = 'text-[11px] uppercase tracking-wider font-semibold text-gold-dark mb-2 pb-1 border-b border-border-soft';
    $countClass = 'text-xs text-muted/60 ml-2';
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
                                <a href="{{ route('properties.index', ['purpose' => $purpose, 'location' => $name]) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $name }}</span>
                                    <span class="{{ $countClass }}">{{ $count }}</span>
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
                        @foreach($menu['uses'] as $use)
                            <li>
                                <a href="{{ route('properties.index', ['purpose' => $purpose, 'use' => $use['slug']]) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $use['name'] }}</span>
                                    <span class="{{ $countClass }}">{{ $use['count'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CATEGORY (with bedroom flyout) --}}
            @if(!empty($menu['categories']))
                <div class="flex-1 min-w-[170px]">
                    <div class="{{ $headingClass }}">Category</div>
                    <ul class="space-y-0.5">
                        @foreach($menu['categories'] as $cat)
                            <li class="group">
                                <a href="{{ route('properties.index', ['purpose' => $purpose, 'category' => $cat['slug']]) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $cat['name'] }}</span>
                                    <span class="flex items-center gap-1 {{ $countClass }}">
                                        {{ $cat['count'] }}
                                        @if($cat['flyout'])
                                            <svg class="w-3 h-3 transition-transform group-hover:rotate-90 group-focus-within:rotate-90"
                                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        @endif
                                    </span>
                                </a>

                                @if($cat['flyout'])
                                    <ul
                                        class="hidden group-hover:block group-focus-within:block ml-3 mt-0.5 mb-1 pl-2 border-l border-gold/30 space-y-0.5">
                                        <li>
                                            <a href="{{ route('properties.index', ['purpose' => $purpose, 'category' => $cat['slug']]) }}"
                                                class="{{ $linkClass }} !text-xs">
                                                <span>Any {{ $cat['name'] }}</span>
                                                <span class="text-muted/60 ml-2">{{ $cat['count'] }}</span>
                                            </a>
                                        </li>
                                        @foreach($cat['bedrooms'] as $bed)
                                            <li>
                                                <a href="{{ route('properties.index', ['purpose' => $purpose, 'category' => $cat['slug'], 'bedrooms' => $bed['value']]) }}"
                                                    class="{{ $linkClass }} !text-xs">
                                                    <span>{{ $bed['label'] }}</span>
                                                    <span class="text-muted/60 ml-2">{{ $bed['count'] }}</span>
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
                        @foreach($menu['budgets'] as $budget)
                            <li>
                                <a href="{{ route('properties.index', array_filter([
                                    'purpose' => $purpose,
                                    'min_price' => $budget['min'],
                                    'max_price' => $budget['max'],
                                ], fn ($v) => $v !== null)) }}" class="{{ $linkClass }}">
                                    <span>{{ $budget['label'] }}</span>
                                    <span class="{{ $countClass }}">{{ $budget['count'] }}</span>
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
                        @foreach($menu['types'] as $type)
                            <li>
                                <a href="{{ route('properties.index', ['purpose' => $purpose, 'type' => $type['slug']]) }}"
                                    class="{{ $linkClass }}">
                                    <span>{{ $type['name'] }}</span>
                                    <span class="{{ $countClass }}">{{ $type['count'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="mt-5 pt-3 border-t border-border-soft text-right">
            <a href="{{ route('properties.index', ['purpose' => $purpose]) }}"
                class="text-sm font-medium text-gold-dark hover:text-gold transition">
                View all {{ $purpose === 'rent' ? 'rentals' : 'properties for sale' }} →
            </a>
        </div>
    </div>
@else
    <div class="px-6 py-12 text-center">
        <div class="text-sm text-muted italic">
            No properties {{ $purpose === 'rent' ? 'for rent' : 'for sale' }} yet.
        </div>
        <p class="text-xs text-muted/60 mt-2">Listings will appear here as soon as they are added.</p>
    </div>
@endif
