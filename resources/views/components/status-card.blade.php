@props([
    'status' => null,
    'ttd' => null, // tandatangan_pimpinan
])

@php
    $statusText = match (true) {
        is_null($status) => 'Pending',
        $status == 0 => 'Ditolak',
        $status == 1 && $ttd == 1 => 'Diterima',
        $status == 1 && $ttd == null => 'Menunggu TTD',
        default => 'Diproses',
    };

    $colorClasses = match (true) {
        is_null($status) => 'bg-status-yellow',
        $status == 0 => 'bg-status-red',
        $status == 1 && $ttd == 1 => 'bg-status-green',
        $status == 1 && $ttd == null => 'bg-status-yellow',
        default => 'bg-gray-400',
    };
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider {$colorClasses}"
]) }}>
    {{ $slot->isEmpty() ? $statusText : $slot }}
</span>