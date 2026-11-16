@props(['statusMenu'])

<div x-data="{ open: false, activeStatus: null, timer: null, subTimer: null }"
    @mouseenter="clearTimeout(timer); timer = setTimeout(() => open = true, 100)"
    @mouseleave="clearTimeout(timer); timer = setTimeout(() => { open = false; activeStatus = null }, 300)"
    class="relative">

    {{-- Trigger --}}
    <button type="button" @click="open = !open" class="{{ $baseLink }} inline-flex items-center gap-1" :class="{{ request()->routeIs('projects.*') || request()->query('status')
    ? $activeText
    : $inactiveText }}">
        Projects
        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Main panel --}}
    <div x-show="open" x-cloak @click.outside="open = false; activeStatus = null"
        x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 mt-2 w-72 bg-white border border-stone-line rounded-lg shadow-xl py-2 z-50">

        {{-- Status rows --}}
        @foreach($statusMenu as $key => $status)
            <div class="relative" @mouseenter="clearTimeout(subTimer); activeStatus = '{{ $key }}'"
                @mouseleave="subTimer = setTimeout(() => activeStatus = null, 200)">

                <a href="{{ route('projects.index', ['status' => $key]) }}" class="flex items-center justify-between px-4 py-2.5 text-sm transition
                              {{ $status['has_data']
            ? 'text-charcoal-soft hover:bg-cream hover:text-camel'
            : 'text-charcoal-soft/40 cursor-not-allowed pointer-events-none' }}">

                    <span class="font-medium">{{ $status['label'] }}</span>
                    <span class="flex items-center gap-2 text-xs text-charcoal-soft/60">
                        {{ $status['count'] }}
                        @if($status['has_data'])
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    </span>
                </a>

                {{-- Submenu (countries) --}}
                @if($status['has_data'])
                    <div x-show="activeStatus === '{{ $key }}'" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-2"
                        class="absolute left-full top-0 ml-1 w-56 bg-white border border-stone-line rounded-lg shadow-xl py-2 z-50">

                        <div
                            class="px-4 py-2 text-[10px] font-semibold uppercase tracking-wider text-camel border-b border-stone-line mb-1">
                            {{ $status['label'] }} by country
                        </div>

                        @foreach($status['countries'] as $country)
                            <a href="{{ route('projects.index', ['status' => $key, 'country' => $country['slug']]) }}"
                                class="flex items-center justify-between px-4 py-2 text-sm text-charcoal-soft hover:bg-cream hover:text-camel transition">
                                <span>{{ $country['name'] }}</span>
                                <span class="text-xs text-charcoal-soft/60">{{ $country['count'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Footer --}}
        <div class="border-t border-stone-line mt-2 pt-2">
            <a href="{{ route('projects.index') }}"
                class="block px-4 py-2 text-sm font-medium text-camel hover:bg-cream transition">
                View all projects →
            </a>
        </div>
    </div>
</div>