@props([
    'status' => 0,
])

@php
    $statusText = match((int) $status) {
        0 => 'Pending',
        1 => 'Diterima',
        2 => 'Ditolak',
        default => 'Unknown',
    };

    $colorClasses = match((int) $status) {
        0 => 'bg-status-yellow',
        1 => 'bg-status-green',
        2 => 'bg-status-red',
        default => 'bg-gray-400 shadow-sm',
    };
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center px-10.5 py-4 text-lg font-bold text-white uppercase rounded-full tracking-wider {$colorClasses}"
]) }}>
    {{ $slot->isEmpty() ? $statusText : $slot }}
</span>