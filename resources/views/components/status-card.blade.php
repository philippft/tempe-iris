@props([
    'status' => 0,
])

@php
    $statusText = match((int) $status) {
        NULL => 'Pending',
        0 => 'Ditolak',
        1 => 'Diterima',
        default => 'Unknown',
    };

    $colorClasses = match((int) $status) {
        NULL => 'bg-status-yellow',
        0 => 'bg-status-red',
        1 => 'bg-status-green',
        default => 'bg-gray-400 shadow-sm',
    };
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center px-10.5 py-4 text-lg font-bold text-white uppercase rounded-full tracking-wider {$colorClasses}"
]) }}>
    {{ $slot->isEmpty() ? $statusText : $slot }}
</span>