@props([
    'image' => null,
    'name',
    'category',
    'quantity'
])

<div {{ $attributes->merge(['class' => 'w-full flex items-center gap-5 p-4 bg-white']) }}>
    
    <div class="w-40 h-40 shrink-0 rounded-xl border border-border-custom overflow-hidden">
        @if($image)
            <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center bg-bg-dark text-subtext/40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
            </div>
        @endif
    </div>

    <div class="grow flex flex-col justify-center min-w-0">
        <span class="block text-xs font-bold text-dark-grey uppercase tracking-wider mb-0.5">Nama Barang</span>
        <h4 class="text-xl font-bold text-primary-hover truncate mb-5">{{ $name }}</h4>

        <span class="block text-sm font-bold text-dark-grey uppercase tracking-wider mb-0.5">Kategori</span>
        <p class="text-xl font-semibold text-judul mb-5 truncate">{{ $category }}</p>

        <div class="flex items-center gap-1.5 mt-0.5 text-base font-bold text-dark-grey">
            <span class="uppercase tracking-wider">Jumlah :</span>
            <span class="text-judul">{{ $quantity }}</span>
        </div>
    </div>

</div>