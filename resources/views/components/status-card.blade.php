@props([
    'status' => null,
])

@php
    $raw = is_null($status) ? null : (int) $status;

    $statusText = match($raw) {
        null => 'Pending',
        0    => 'Ditolak',
        1    => 'Diterima',
        default => 'Unknown',
    };

    $colorClasses = match($raw) {
        null => 'bg-status-yellow',
        0    => 'bg-status-red',
        1    => 'bg-status-green',
        default => 'bg-gray-400 shadow-sm',
    };
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider {$colorClasses}"
]) }}>
    {{ $slot->isEmpty() ? $statusText : $slot }}
</span>