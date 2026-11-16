@extends('layouts.app')
@section('title', 'China Portfolio — Nanchong Group')
@section('content')
<x-section eyebrow="Group Track Record" title="China Portfolio">
    <p class="text-charcoal-soft mb-6">Browse our full China project portfolio.</p>
    <a href="{{ route('projects.index', ['country' => 'china']) }}" class="btn-primary">View China projects →</a>
</x-section>
@endsection