@extends('layouts.app')
@section('title', 'Board of Directors — Nanchong Group')
@section('content')
    <x-section eyebrow="About" title="Board of Directors"
        subtitle="The leadership guiding Nanchong Group's vision and governance.">
        @if($members->isEmpty())
            <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                Board information is being updated. Please check back soon.
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($members as $m)
                    <div class="bg-white border border-stone-line rounded-lg p-6 text-center">
                        @if($m->photo)
                            <img src="{{ asset('storage/' . $m->photo) }}" alt="{{ $m->name }}"
                                class="w-32 h-32 mx-auto rounded-full object-cover mb-4 border-4 border-cream">
                        @else
                            <div
                                class="w-32 h-32 mx-auto rounded-full bg-camel/20 flex items-center justify-center text-camel text-3xl font-semibold mb-4">
                                {{ strtoupper(substr($m->name, 0, 1)) }}
                            </div>
                        @endif
                        <h3 class="text-lg font-semibold text-charcoal">{{ $m->name }}</h3>
                        <div class="text-xs uppercase tracking-wider text-camel font-medium mt-1 mb-3">{{ $m->role }}</div>
                        @if($m->bio)
                            <p class="text-sm text-charcoal-soft leading-relaxed">{{ Str::limit($m->bio, 180) }}</p>
                        @endif
                        @if($m->linkedin_url)
                            <a href="{{ $m->linkedin_url }}" target="_blank" rel="noopener"
                                class="inline-block mt-4 text-sm text-camel hover:text-dusty-taupe">LinkedIn →</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </x-section>
@endsection