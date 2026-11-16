@extends('layouts.app')
@section('title', $project->name . ' — Nanchong Group')
@section('content')
<x-section :eyebrow="$project->address" :title="$project->name">
    <p class="text-charcoal-soft max-w-3xl">{{ $project->description }}</p>
</x-section>
@endsection