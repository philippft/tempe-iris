@props(['variant' => 'primary'])

@php
    $baseClass = "px-6 py-3 rounded-xl font-medium text-xl transition flex items-center gap-2 shadow-sm"; 
    
    $variants = [
        'primary' => 'bg-primary hover:bg-primary-hover text-white',
        'secondary' => 'bg-bg-light border border-border-custom hover:bg-bg-dark text-gray-700'
    ];

    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>