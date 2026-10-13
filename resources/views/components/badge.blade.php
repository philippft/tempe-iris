@props([
    'status' => null,   // Properti baru untuk menerima data status
    'label1' => '',     // Teks utama (fallback jika tidak pakai status)
    'label2' => '',     // Teks sekunder (opsional)
    'variant' => '',    // Pilihan: 'green', 'yellow', 'red' (fallback)
])

@php
    // Jika ada data status yang dikirim, otomatis tentukan variant dan teksnya
    if ($status !== null) {
        // Seragamkan menjadi huruf kecil semua untuk pengecekan
        $cekStatus = strtolower(trim((string) $status));
        
        // Tentukan warna otomatis berdasarkan kata kunci status
        $variant = match(true) {
            in_array($cekStatus, ['aktif', '1', 'diterima', 'approved']) => 'green',
            in_array($cekStatus, ['pending', 'menunggu', 'diproses']) => 'yellow',
            in_array($cekStatus, ['tidak aktif', '0', 'ditolak', 'rejected']) => 'red',
            default => 'default',
        };

        // Otomatis atur teks Label 1 berdasarkan status jika tidak diisi manual
        if ($label1 === '') {
            $label1 = match($cekStatus) {
                NULL => 'Pending',
                '1' => 'Aktif',
                '0' => 'Tidak Aktif',
                default => ucfirst($status), // Huruf kapital di awal kata
            };
        }
    }

    // Mengatur palet warna (Latar & Border, Titik, dan Teks)
    $colors = match($variant) {
        'red' => [
            'wrapper' => 'bg-red-50 border-red-200',
            'dot'     => 'bg-red-600',
            'text'    => 'text-red-700',
        ],
        'yellow' => [
            'wrapper' => 'bg-amber-50 border-amber-200',
            'dot'     => 'bg-amber-500',
            'text'    => 'text-amber-600',
        ],
        'green' => [
            'wrapper' => 'bg-[#E6F8F0] border-[#BDE8D6]',
            'dot'     => 'bg-[#0C7351]',
            'text'    => 'text-[#0C7351]',
        ],
        default => [
            'wrapper' => 'bg-[#E6F8F0] border-[#BDE8D6]',
            'dot'     => 'bg-[#0C7351]',
            'text'    => 'text-[#0C7351]',
        ],
    };
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-3 py-1.5 border rounded-full ' . $colors['wrapper']]) }}>
    
    <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $colors['dot'] }}"></span>
    
    <span class="text-sm font-bold tracking-wide {{ $colors['text'] }}">
        @if ($label2 !== '')
            {{-- Jika label 2 diisi, tampilkan format "Label1: Label2" --}}
            {{ $label1 }}: {{ $label2 }}
        @else
            {{-- Jika label 2 kosong, tampilkan hanya Label 1 --}}
            {{ $label1 }}
        @endif
    </span>
    
</div>