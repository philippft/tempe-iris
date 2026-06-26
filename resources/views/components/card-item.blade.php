@props([
    'image' => null,           // URL gambar barang
    'title' => 'Nama Barang',  // Nama barang
    'category' => 'Kategori Barang', // Kategori
    'stock' => 5,              // Jumlah stok tersedia
])

{{-- x-data untuk membuat interaksi tambah/kurang jumlah pinjam --}}
<div x-data="{ quantity: 1, maxStock: {{ $stock }} }" class="p-5 border border-border-custom rounded-[28px] bg-white max-w-85 flex flex-col gap-5">
    
    <div class="w-full h-50 bg-[#D9D9D9] rounded-xl overflow-hidden shrink-0">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        @endif
    </div>

    <div class="flex flex-col gap-1 cursor-default">
        <h3 class="text-3xl font-bold text-judul tracking-tight">{{ $title }}</h3>
        <p class="text-base text-subtext font-medium">{{ $category }}</p>
    </div>

    <div class="-mx-1">
        {{-- Memanggil komponen badge --}}
        <x-badge label1="Tersedia" :label2="$stock" class="cursor-default" />
    </div>

    <div class="flex items-center justify-between mt-2">
        <span class="text-sm font-bold tracking-wider uppercase cursor-default text-judul">Jumlah Pinjam</span>
        
        <div class="flex items-center gap-3">
            {{-- Tombol Minus --}}
            <button 
                type="button" 
                @click="if(quantity > 1) quantity--"
                class="flex items-center justify-center w-10 h-10 bg-primary-hover text-white rounded-lg hover:bg-primary active:scale-95 transition-all disabled:opacity-50"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </button>
            
            {{-- Angka Jumlah --}}
            <span class="font-semibold text-lg w-4 text-center text-judul cursor-default" x-text="quantity">1</span>
            
            {{-- Tombol Plus --}}
            <button 
                type="button" 
                @click="if(quantity < maxStock) quantity++"
                class="flex items-center justify-center w-10 h-10 bg-primary-hover text-white rounded-lg hover:bg-primary active:scale-95 transition-all disabled:opacity-50"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
        </div>
    </div>

    <div class="flex items-stretch gap-3 mt-1">
        {{-- Tombol Mata --}}
        {{-- Perhatikan penggunaan tanda seru (!) untuk override class bawaan dari komponen action-button --}}
        <x-action-button 
            type="view" 
            as="button" 
            class="!w-14 !h-14 !text-white !bg-primary-hover hover:!bg-primary !rounded-xl shrink-0" 
        />
        
        {{-- Tombol Pilih Barang --}}
        <x-button class="flex-1 bg-primary-hover cursor-default text-white hover:bg-primary text-lg font-bold rounded-xl justify-center font-sans transition-colors">
            Pilih Barang
        </x-button>
    </div>

</div>