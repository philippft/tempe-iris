@props([
    'variant' => '', // Pilihan: 'green' atau 'yellow'
    'label'   => '',
    'number'  => '',
    'unit'    => null,
])

@php
    // Menentukan background utama berdasarkan variant
    $bgClass = match($variant) {
        'yellow' => 'bg-status-yellow',
        'green'  => 'bg-status-green',
        default  => 'bg-status-green',
    };
@endphp

<div {{ $attributes->merge(['class' => "p-7 rounded-[24px] text-white flex flex-col justify-between min-h-[160px] shadow-sm $bgClass"]) }}>
    
    {{-- Bagian Atas: Label & Ikon --}}
    <div class="flex items-start justify-between">
        <h3 class="text-[22px] font-semibold tracking-wide">{{ $label }}</h3>
        
        {{-- Wadah Ikon (Transparan 20%) --}}
        <div class="w-14 h-14 rounded-[14px] bg-white/20 flex items-center justify-center shrink-0">
            {{-- Prioritaskan slot jika ada custom icon --}}
            @if(isset($icon))
                {{ $icon }}
            @else
                {{-- Default Icon Berdasarkan Variant --}}
                @if($variant === 'yellow')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            @endif
        </div>
    </div>
    
    {{-- Bagian Bawah: Angka & Unit --}}
    <div class="flex items-baseline gap-3 mt-6">
        <span class="text-[64px] font-bold leading-none tracking-tight">{{ $number }}</span>
        
        @if($unit)
            <span class="text-xl font-medium tracking-wide">{{ $unit }}</span>
        @endif
    </div>
</div>