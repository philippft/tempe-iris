@props([
    'status' => 'aktif', 
])

@php
    $colorClasses = match(strtolower($status)) {
        'aktif' => 'bg-status-green', 
        'nonaktif' => 'bg-status-red',
        'pending' => 'bg-status-yellow',
        default => 'bg-gray-400 shadow-sm',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-10.5 py-4 text-lg font-bold text-white uppercase rounded-full tracking-wider {$colorClasses}"]) }}>
    {{ $slot->isEmpty() ? $status : $slot }}
</span>