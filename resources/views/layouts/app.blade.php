<!DOCTYPE html>
@php
    $megaMenu = app(\App\Services\MegaMenuService::class)->data();
    $projectStatusMenu = app(\App\Services\MegaMenuService::class)->projectStatusMenu();

    $isHome = request()->routeIs('home');
    $homeLit = $isHome ? 'true' : 'false';

    $baseLink = 'text-sm font-medium transition-colors whitespace-nowrap';
    $inactiveText = "'text-cream/90 hover:text-gold'";
    $activeText = "'text-gold border-b-2 border-gold pb-1'";
    $burgerCls = "'text-cream hover:text-gold'";
    $contactBtn = "'inline-flex items-center justify-center px-5 py-2.5 rounded-md font-bold text-sm text-white transition hover:brightness-110'";

    $waPrimary = \App\Models\SiteContact::primary();
    $waNumber = preg_replace('/\D/', '', $waPrimary->phone ?? '') ?: '254799934180';
    $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode("Hi Buy Property Nairobi, I'd like to know more about your properties.");
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Buy Property Nairobi — Premium Properties & New Developments')</title>
    <meta name="description"
        content="@yield('meta_description', 'Explore premium property for sale and rent in Nairobi — Kilimani, Kileleshwa, Westlands and Karen. Buy Property Nairobi — property specialists.')">

    {{-- SEO --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="Buy Property Nairobi">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Buy Property Nairobi — Premium Properties')">
    <meta property="og:description"
        content="@yield('meta_description', 'Premium property for sale and rent in Nairobi.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    <meta property="og:image:alt" content="@yield('title', 'Buy Property Nairobi')">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Buy Property Nairobi')">
    <meta name="twitter:description"
        content="@yield('meta_description', 'Premium property for sale and rent in Nairobi.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))">

    {{-- Robots --}}
    <meta name="robots" content="@yield('robots', 'index, follow')">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    {{-- Hides Alpine-controlled elements until Alpine starts --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ atTop: true }"
    x-init="atTop = window.scrollY < 40; window.addEventListener('scroll', () => atTop = window.scrollY < 40, { passive: true })"
    id="top" class="bg-cream text-ink antialiased min-h-screen flex flex-col">

    {{-- ==================== HEADER ==================== --}}
    <header x-data class="bg-emerald-dark border-b border-emerald sticky top-0 z-40 shadow-lg">

        <div class="pl-3 pr-4 sm:pl-4 sm:pr-6 lg:pl-6 lg:pr-8">
            <div class="flex items-center h-16 sm:h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0"
                    aria-label="Buy Property Nairobi">

                    <span class="bg-cream rounded-md p-1.5 shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Buy Property Nairobi"
                            class="h-11 sm:h-12 w-auto object-contain">
                    </span>

                </a>
                {{-- Desktop Nav --}}
                <nav class="hidden md:flex flex-1 items-center gap-2 lg:gap-4 ml-4 lg:ml-8 min-w-0">

                    <a href="{{ route('home') }}" class="{{ $baseLink }}"
                        :class="{{ request()->routeIs('home') ? $activeText : $inactiveText }}">
                        Home
                    </a>

                    {{-- BUY --}}
                    <div x-data="{ open: false, timer: null }"
                        @mouseenter="clearTimeout(timer); timer = setTimeout(() => open = true, 100)"
                        @mouseleave="clearTimeout(timer); timer = setTimeout(() => open = false, 300)" class="shrink-0">
                        <button type="button" @click="open = !open"
                            class="{{ $baseLink }} inline-flex items-center gap-1"
                            :class="{{ request()->query('purpose') === 'buy' ? $activeText : $inactiveText }}">
                            Buy
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        {{-- dropdown content unchanged --}}
                        <div x-show="open" x-cloak @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-1/2 -translate-x-1/2 w-[920px] max-w-[95vw] bg-white border border-border-soft rounded-lg shadow-2xl z-50 overflow-hidden">
                            @php($menu = array_merge($megaMenu['buy'], ['purpose' => 'buy']))
                            <x-mega-menu :menu="$menu" />
                        </div>
                    </div>

                    {{-- RENT --}}
                    <div x-data="{ open: false, timer: null }"
                        @mouseenter="clearTimeout(timer); timer = setTimeout(() => open = true, 100)"
                        @mouseleave="clearTimeout(timer); timer = setTimeout(() => open = false, 300)" class="shrink-0">
                        <button type="button" @click="open = !open"
                            class="{{ $baseLink }} inline-flex items-center gap-1"
                            :class="{{ request()->query('purpose') === 'rent' ? $activeText : $inactiveText }}">
                            Rent
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-1/2 -translate-x-1/2 w-[920px] max-w-[95vw] bg-white border border-border-soft rounded-lg shadow-2xl z-50 overflow-hidden">
                            @php($menu = array_merge($megaMenu['rent'], ['purpose' => 'rent']))
                            <x-mega-menu :menu="$menu" />
                        </div>
                    </div>

                    {{-- ABOUT --}}
                    <div x-data="{ open: false, timer: null }"
                        @mouseenter="clearTimeout(timer); timer = setTimeout(() => open = true, 100)"
                        @mouseleave="clearTimeout(timer); timer = setTimeout(() => open = false, 300)"
                        class="relative shrink-0">
                        <button type="button" @click="open = !open"
                            class="{{ $baseLink }} inline-flex items-center gap-1"
                            :class="{{ request()->routeIs('about*') || request()->routeIs('cooperate') ? $activeText : $inactiveText }}">
                            About
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-0 mt-2 w-64 bg-white border border-border-soft rounded-lg shadow-xl py-2 z-50">
                            <a href="{{ route('about') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">About
                                Company</a>
                            <a href="{{ route('about.board') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Board
                                of Directors</a>
                            <a href="{{ route('about.management') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Management</a>
                            <a href="{{ route('cooperate') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Partner
                                With Us</a>
                            <a href="{{ route('about.careers') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Work
                                With Us</a>
                        </div>
                    </div>

                    {{-- PROJECTS --}}
                    <div x-data="{ open: false, activeStatus: null, flip: false, timer: null, subTimer: null }"
                        @mouseenter="clearTimeout(timer); timer = setTimeout(() => open = true, 100)"
                        @mouseleave="clearTimeout(timer); timer = setTimeout(() => { open = false; activeStatus = null }, 300)"
                        class="relative shrink-0">
                        <button type="button" @click="open = !open"
                            class="{{ $baseLink }} inline-flex items-center gap-1"
                            :class="{{ request()->routeIs('projects.*') || request()->query('status') ? $activeText : $inactiveText }}">
                            Projects
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false; activeStatus = null"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1" x-ref="dd"
                            class="absolute right-0 mt-2 w-72 max-w-[calc(100vw-1rem)] bg-white border border-border-soft rounded-lg shadow-xl py-2 z-50">
                            @foreach($projectStatusMenu as $key => $status)
                                <div class="relative"
                                    @mouseenter="clearTimeout(subTimer); activeStatus = '{{ $key }}'; flip = $refs.dd.getBoundingClientRect().left < 240"
                                    @mouseleave="subTimer = setTimeout(() => activeStatus = null, 200)">
                                    <a href="{{ route('projects.index', ['status' => $key]) }}"
                                        class="flex items-center justify-between px-4 py-2.5 text-sm transition {{ $status['has_data'] ? 'text-muted hover:bg-cream hover:text-gold-dark' : 'text-muted/40 cursor-not-allowed pointer-events-none' }}">
                                        <span class="font-medium">{{ $status['label'] }}</span>
                                        <span class="flex items-center gap-2 text-xs text-muted/60">
                                            {{ $status['count'] }}
                                            @if($status['has_data'])
                                                <svg class="w-3 h-3" :class="flip ? 'rotate-180' : ''" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 19l-7-7 7-7" />
                                                </svg>
                                            @endif
                                        </span>
                                    </a>
                                    @if($status['has_data'])
                                        <div x-show="activeStatus === '{{ $key }}'" x-cloak
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 translate-x-2"
                                            x-transition:enter-end="opacity-100 translate-x-0"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 translate-x-0"
                                            x-transition:leave-end="opacity-0 translate-x-2"
                                            :class="flip ? 'left-full ml-1' : 'right-full mr-1'"
                                            class="absolute top-0 w-56 bg-white border border-border-soft rounded-lg shadow-xl py-2 z-50">
                                            <div
                                                class="px-4 py-2 text-[10px] font-semibold uppercase tracking-wider text-gold-dark border-b border-border-soft mb-1">
                                                {{ $status['label'] }} by country
                                            </div>
                                            @foreach($status['countries'] as $country)
                                                <a href="{{ route('projects.index', ['status' => $key, 'country' => $country['slug']]) }}"
                                                    class="flex items-center justify-between px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">
                                                    <span>{{ $country['name'] }}</span>
                                                    <span class="text-xs text-muted/60">{{ $country['count'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="border-t border-border-soft mt-2 pt-2">
                                <a href="{{ route('projects.index') }}"
                                    class="block px-4 py-2 text-sm font-medium text-gold-dark hover:bg-cream transition">
                                    View all projects →
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- TESTIMONIALS --}}
                    <a href="{{ route('testimonials') }}" class="{{ $baseLink }} shrink-0 hidden xl:inline-block"
                        :class="{{ request()->routeIs('testimonials') ? $activeText : $inactiveText }}">
                        Testimonials
                    </a>

                    {{-- MEDIA --}}
                    <div x-data="{ open: false, timer: null }"
                        @mouseenter="clearTimeout(timer); timer = setTimeout(() => open = true, 100)"
                        @mouseleave="clearTimeout(timer); timer = setTimeout(() => open = false, 300)"
                        class="relative shrink-0">
                        <button type="button" @click="open = !open"
                            class="{{ $baseLink }} inline-flex items-center gap-1"
                            :class="{{ request()->routeIs('media.*') || request()->routeIs('insights.*') ? $activeText : $inactiveText }}">
                            Media
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute right-0 mt-2 w-64 bg-white border border-border-soft rounded-lg shadow-xl py-2 z-50">
                            <a href="{{ route('media.area-guides') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Area
                                Guides</a>
                            <a href="{{ route('media.blog') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Blog</a>
                            <a href="{{ route('insights.index') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Market
                                Insights</a>
                            <a href="{{ route('media.faqs') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">FAQs</a>
                            <a href="{{ route('media.video-tours') }}"
                                class="block px-4 py-2 text-sm text-muted hover:bg-cream hover:text-gold-dark transition">Video
                                Tours</a>
                        </div>
                    </div>

                    {{-- RIGHT-SIDE CTAs — NEVER SHRINK --}}
                    <div class="ml-auto flex items-center gap-2 flex-shrink-0">
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp"
                            title="Chat on WhatsApp"
                            class="inline-flex shrink-0 items-center justify-center w-10 h-10 rounded-full bg-[#25D366] text-white shadow-sm hover:bg-[#1ebe5b] hover:scale-105 transition">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-md font-bold text-sm text-white transition hover:brightness-110 shadow-sm whitespace-nowrap"
                            style="background-image: linear-gradient(115deg, #b47c2f, #dda950);">
                            Book a Viewing →
                        </a>
                    </div>
                </nav>

                {{-- Mobile hamburger --}}
                <button type="button" class="md:hidden ml-auto p-3 transition" :class="{{ $burgerCls }}"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" aria-label="Menu">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu"
            class="hidden md:hidden max-h-[calc(100vh-8rem)] overflow-y-auto bg-emerald-dark border-t border-emerald">
            <nav class="px-4 py-4 flex flex-col gap-3">

                <a href="{{ route('home') }}" class="text-sm font-medium text-cream/85 hover:text-gold">Home</a>

                {{-- Mobile Buy --}}
                <div x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="w-full text-left text-sm font-medium text-cream/85 hover:text-gold flex items-center justify-between">
                        Buy
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="mt-2 pl-4 space-y-3 border-l border-gold/30">
                        @if(!empty($megaMenu['buy']['locations']))
                            <div>
                                <div class="text-xs uppercase tracking-wider text-gold font-semibold mb-1">Location</div>
                                @foreach($megaMenu['buy']['locations'] as $slug => $count)
                                    <a href="{{ route('projects.index', ['purpose' => 'buy', 'location' => $slug]) }}"
                                        class="block text-sm text-cream/75 hover:text-cream py-0.5">
                                        {{ $slug }} <span class="text-cream/40 text-xs">({{ $count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        <a href="{{ route('projects.index', ['purpose' => 'buy']) }}"
                            class="block text-sm text-gold font-medium mt-2">View all for sale →</a>
                    </div>
                </div>

                {{-- Mobile Rent --}}
                <div x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="w-full text-left text-sm font-medium text-cream/85 hover:text-gold flex items-center justify-between">
                        Rent
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="mt-2 pl-4 space-y-3 border-l border-gold/30">
                        @if(!empty($megaMenu['rent']['has_data']))
                            {{-- mirror buy structure --}}
                        @else
                            <div class="text-sm text-cream/60 italic">No rentals yet.</div>
                        @endif
                        <a href="{{ route('projects.index', ['purpose' => 'rent']) }}"
                            class="block text-sm text-gold font-medium mt-2">View rentals →</a>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="text-sm font-medium text-cream/85 hover:text-gold">About</a>

                {{-- Mobile Projects --}}
                <div x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="w-full text-left text-sm font-medium text-cream/85 hover:text-gold flex items-center justify-between">
                        <span>Projects</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="mt-2 pl-4 flex flex-col gap-2 border-l border-gold/30">
                        @foreach($projectStatusMenu as $key => $status)
                            <div x-data="{ sopen: false }">
                                <button type="button" @click="sopen = !sopen" @if(!$status['has_data']) disabled @endif
                                    class="w-full flex items-center justify-between text-sm py-1 {{ $status['has_data'] ? 'text-cream/75 hover:text-cream' : 'text-cream/30 cursor-not-allowed' }}">
                                    <span>{{ $status['label'] }}
                                        <span class="text-cream/40 text-xs">({{ $status['count'] }})</span>
                                    </span>
                                    @if($status['has_data'])
                                        <svg class="w-3 h-3 transition-transform" :class="sopen ? 'rotate-180' : ''" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    @endif
                                </button>
                                @if($status['has_data'])
                                    <div x-show="sopen" x-cloak class="pl-3 mt-1 flex flex-col gap-1 border-l border-cream/10">
                                        @foreach($status['countries'] as $country)
                                            <a href="{{ route('projects.index', ['status' => $key, 'country' => $country['slug']]) }}"
                                                class="text-xs text-cream/70 hover:text-cream py-0.5">
                                                {{ $country['name'] }}
                                                <span class="text-cream/40">({{ $country['count'] }})</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <a href="{{ route('projects.index') }}"
                            class="text-sm text-gold hover:text-cream font-medium pt-1">
                            View all →
                        </a>
                    </div>
                </div>

                {{-- Mobile About --}}
                <div x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="w-full text-left text-sm font-medium text-cream/85 hover:text-gold flex items-center justify-between">
                        About
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="mt-2 pl-4 flex flex-col gap-2 border-l border-gold/30">
                        <a href="{{ route('about') }}" class="text-sm text-cream/75 hover:text-cream">About Company</a>
                        <a href="{{ route('about.board') }}" class="text-sm text-cream/75 hover:text-cream">Board of
                            Directors</a>
                        <a href="{{ route('about.management') }}"
                            class="text-sm text-cream/75 hover:text-cream">Management</a>
                        <a href="{{ route('cooperate') }}" class="text-sm text-cream/75 hover:text-cream">Partner With
                            Us</a>
                        <a href="{{ route('about.careers') }}" class="text-sm text-cream/75 hover:text-cream">Work With
                            Us</a>
                    </div>
                </div>

                <a href="{{ route('testimonials') }}"
                    class="text-sm font-medium text-cream/85 hover:text-gold">Testimonials</a>

                {{-- Mobile Media --}}
                <div x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="w-full text-left text-sm font-medium text-cream/85 hover:text-gold flex items-center justify-between">
                        Media
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="mt-2 pl-4 flex flex-col gap-2 border-l border-gold/30">
                        <a href="{{ route('media.area-guides') }}" class="text-sm text-cream/75 hover:text-cream">Area
                            Guides</a>
                        <a href="{{ route('media.blog') }}" class="text-sm text-cream/75 hover:text-cream">Blog</a>
                        <a href="{{ route('insights.index') }}" class="text-sm text-cream/75 hover:text-cream">Market
                            Insights</a>
                        <a href="{{ route('media.faqs') }}" class="text-sm text-cream/75 hover:text-cream">FAQs</a>
                        <a href="{{ route('media.video-tours') }}" class="text-sm text-cream/75 hover:text-cream">Video
                            Tours</a>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-2">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp"
                        title="Chat on WhatsApp"
                        class="inline-flex shrink-0 items-center justify-center w-10 h-10 rounded-full bg-[#25D366] text-white shadow-sm hover:bg-[#1ebe5b] hover:scale-105 transition">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-gold text-white font-medium text-sm">
                        Contact us
                    </a>
                </div>
            </nav>
        </div>

        {{-- gold hairline at the bottom of the header --}}
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-gold/60 to-transparent"
            aria-hidden="true"></div>
    </header>

    {{-- ==================== MAIN ==================== --}}
    <main class="flex-1 {{ $isHome ? '' : 'pt-16 sm:pt-20' }}">
        @yield('content')
    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="relative isolate mt-16 overflow-hidden bg-emerald-dark text-cream">
        {{-- gold hairline + decorative glows --}}
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-gold to-transparent"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -left-24 -top-24 -z-10 h-64 w-64 rounded-full bg-gold/15 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 -z-10 h-64 w-64 rounded-full bg-gold-dark/20 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid gap-10 md:grid-cols-3">

                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl font-serif font-bold text-gold">▥</span>
                        <div class="leading-tight">
                            <div class="text-xl font-serif font-bold text-cream">Buy Property</div>
                            <div class="text-[10px] tracking-[0.3em] text-gold text-center">— N A I R O B I —</div>
                        </div>
                    </div>
                    <div class="text-sm text-cream/70 mb-4">Premium properties. Trusted expertise. Brighter futures.
                    </div>
                    <div class="text-xs text-cream/60 leading-relaxed">
                        Nairobi, Kenya<br>
                        Property sales · rentals · investments
                    </div>
                </div>

                {{-- Explore --}}
                <div>
                    <div class="text-sm font-semibold uppercase tracking-widest text-gold">Explore</div>
                    <div class="mt-2 mb-4 h-0.5 w-10 rounded-full bg-gradient-to-r from-gold to-gold-dark"
                        aria-hidden="true"></div>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('about') }}"
                                class="inline-block text-cream/70 transition hover:text-gold">About</a></li>
                        <li><a href="{{ route('projects.index') }}"
                                class="inline-block text-cream/70 transition hover:text-gold">Properties</a></li>
                        <li><a href="{{ route('insights.index') }}"
                                class="inline-block text-cream/70 transition hover:text-gold">Insights</a></li>
                        <li><a href="{{ route('cooperate') }}"
                                class="inline-block text-cream/70 transition hover:text-gold">Sell With Us</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="inline-block text-cream/70 transition hover:text-gold">Contact</a></li>
                    </ul>
                </div>

                {{-- Get in touch --}}
                <div>
                    <div class="text-sm font-semibold uppercase tracking-widest text-gold">Get in touch</div>
                    <div class="mt-2 mb-4 h-0.5 w-10 rounded-full bg-gradient-to-r from-gold to-gold-dark"
                        aria-hidden="true"></div>
                    @php($primary = \App\Models\SiteContact::primary())
                    @if($primary)
                        <div class="space-y-1.5">
                            <div class="text-sm text-cream">{{ $primary->name }}</div>
                            @if($primary->role)
                                <div class="text-xs text-cream/60">{{ $primary->role }}</div>
                            @endif
                            @if($primary->phone)
                                <div class="text-sm">
                                    <a href="tel:{{ $primary->phone }}"
                                        class="text-cream/70 hover:text-gold transition">{{ $primary->phone }}</a>
                                </div>
                            @endif
                            @if($primary->email)
                                <div class="text-sm">
                                    <a href="mailto:{{ $primary->email }}"
                                        class="text-cream/70 hover:text-gold transition">{{ $primary->email }}</a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                        class="mt-5 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-[#1ebe5b]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        Chat on WhatsApp
                    </a>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div
                class="mt-12 flex flex-col justify-between gap-2 border-t border-white/10 pt-6 text-xs text-cream/60 md:flex-row md:items-center">
                <div>&copy; {{ date('Y') }} Buy Property Nairobi. All rights reserved.</div>
                <div class="flex items-center gap-4">
                    <span>Premium properties. Brighter futures.</span>
                    <a href="#top" class="inline-flex items-center gap-1 transition hover:text-gold">
                        Back to top
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>