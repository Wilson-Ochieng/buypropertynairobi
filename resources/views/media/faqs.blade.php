@extends('layouts.app')
@section('title', 'FAQs — Nanchong Group')
@section('content')
    <x-section eyebrow="Media" title="Frequently Asked Questions" subtitle="Answers to the questions we hear most often.">
        @if($faqs->isEmpty())
            <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                FAQs are being prepared. Check back soon.
            </div>
        @else
            <div class="max-w-3xl space-y-8">
                @foreach($faqs as $category => $items)
                    <div>
                        @if($category)
                            <h2 class="text-xl font-semibold text-charcoal mb-4">{{ $category }}</h2>
                        @endif
                        <div class="space-y-3" x-data="{ open: null }">
                            @foreach($items as $i => $faq)
                                <div class="border border-stone-line rounded-lg bg-white">
                                    <button type="button" @click="open = open === {{ $i }} ? null : {{ $i }}"
                                        class="w-full text-left px-5 py-4 flex items-center justify-between gap-4">
                                        <span class="font-medium text-charcoal">{{ $faq->question }}</span>
                                        <svg class="w-4 h-4 transition-transform shrink-0 text-camel"
                                            :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="open === {{ $i }}" x-cloak class="px-5 pb-4 prose prose-stone max-w-none text-sm">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-section>
@endsection