@extends('layouts.app')
@section('title', 'Subsidiary Companies — Nanchong Group')
@section('meta_description', 'The four integrated companies that make up Nanchong Group — construction, property management, landscaping, and marketing.')

@section('content')

<section class="bg-brand-gradient text-charcoal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
        <div class="max-w-3xl">
            <div class="text-sm uppercase tracking-widest text-charcoal-soft mb-3">Our Group</div>
            <h1 class="text-4xl md:text-6xl font-semibold leading-tight mb-4">Subsidiary Companies</h1>
            <p class="text-lg md:text-xl text-charcoal-soft">
                An integrated group with end-to-end development capability.
            </p>
        </div>
    </div>
</section>

<x-section>
    @if($subsidiaries->isEmpty())
        <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
            Subsidiary information is being updated. Please check back soon.
        </div>
    @else
        <div class="grid sm:grid-cols-2 gap-6">
            @foreach($subsidiaries as $sub)
                <div class="bg-white border border-stone-line rounded-lg p-6 md:p-8">
                    @if($sub->logo)
                        <img src="{{ asset('storage/' . $sub->logo) }}"
                             alt="{{ $sub->name }}"
                             class="h-12 mb-4 object-contain">
                    @endif
                    <h2 class="text-xl font-semibold text-charcoal mb-1">{{ $sub->name }}</h2>
                    @if($sub->qualification)
                        <div class="text-xs uppercase tracking-wider text-camel font-medium mb-3">
                            {{ $sub->qualification }}
                        </div>
                    @endif
                    @if($sub->description)
                        <p class="text-charcoal-soft leading-relaxed">{{ $sub->description }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-section>

@endsection