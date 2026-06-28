@props([
    'status' => null,
])

@php
    $statusText = match ($status) {
        null => 'Pending',
        false => 'Ditolak',
        true => 'Diterima',
        default => 'Unknown',
    };

    $colorClasses = match ($status) {
        null => 'bg-status-yellow',
        false => 'bg-status-red',
        true => 'bg-status-green',
        default => 'bg-gray-400 shadow-sm',
    };
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider {$colorClasses}"
]) }}>
    {{ $slot->isEmpty() ? $statusText : $slot }}
</span>