@props(['type' => 'success'])

@php
    $classes = [
        'success' => 'bg-ash-grey border-camel text-charcoal',
        'error' => 'bg-red-50 border-red-300 text-red-800',
    ][$type] ?? 'bg-ash-grey border-camel text-charcoal';
@endphp

<div {{ $attributes->merge(['class' => "border-l-4 p-4 rounded-r-md {$classes}"]) }}>
    {{ $slot }}
</div>