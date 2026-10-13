@props([
    'title' => 'Tidak Ada Data',
    'message' => 'Saat ini belum ada data yang tersedia atau tidak ada data yang cocok dengan pencarian Anda.'
])

<!-- note: Pastikan menggunakan forelse ya, bukan foreach -->

<div {{ $attributes->merge(['class' => 'w-full flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-b-2xl']) }}>
    <div class="w-16 h-16 bg-bg-dark rounded-2xl flex items-center justify-center text-dark-grey/40 mb-4 border border-border-custom/20">
        @if(isset($icon))
            {{ $icon }}
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
        @endif
    </div>
    
    <h4 class="text-base font-bold text-judul mb-1">
        {{ $title }}
    </h4>
    
    <p class="text-sm text-dark-grey max-w-sm">
        {{ $message }}
    </p>
</div>