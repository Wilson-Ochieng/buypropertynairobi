@extends('layouts.app')

@section('title', 'Application Received — Nanchong Group')
@section('robots', 'noindex, nofollow')

@section('content')
<x-section>
    <div class="max-w-xl mx-auto text-center py-12">
        <div class="w-20 h-20 rounded-full bg-camel/20 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-camel" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-semibold text-charcoal mb-3">Application received</h1>
        <p class="text-charcoal-soft mb-8">
            Thank you for your interest in joining Nanchong Group. Our HR team will review your application and reach out if there's a fit.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('home') }}" class="btn-secondary">Return home</a>
            <a href="{{ route('about.careers') }}" class="btn-primary">View open positions</a>
        </div>
    </div>
</x-section>
@endsection