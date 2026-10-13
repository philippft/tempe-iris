@props([
    'id' => null,
    'image' => null,
    'title' => '',
    'category' => '',
    'stock' => 0,
])

<div x-data="{
        quantity: 1,
        maxStock: {{ (int) ($stock ?? 0) }},
        itemId: {{ (int) ($id ?? 0) }}, // Dibuat integer agar strict equality (===) di keranjang berfungsi
        dipilih: false,

        init() {
            // Mengecek apakah barang ini sudah ada di keranjang (localStorage)
            let cart = JSON.parse(localStorage.getItem('cart_peminjaman') || '[]');
            let existingItem = cart.find(b => b.id === this.itemId);
            
            if (existingItem) {
                this.dipilih = true;
                this.quantity = existingItem.jumlah;
            }
        },

        tambah() {
            if (this.quantity < this.maxStock) this.quantity++;
            this.dipilih = false; // Reset tulisan agar user tahu dia bisa klik update
        },

        kurang() {
            if (this.quantity > 1) this.quantity--;
            this.dipilih = false;
        },

        pilihBarang() {
            if (this.maxStock < 1) {
                alert('Maaf, stok barang sedang kosong!');
                return;
            }

            $dispatch('barang-dipilih', {
                id: this.itemId,
                nama: '{{ addslashes($title) }}', // addslashes untuk mencegah error jika ada tanda kutip di nama barang
                jumlah: this.quantity
            });

            this.dipilih = true;
        }
    }"

    class="p-4 border border-border-custom rounded-2xl bg-white w-full flex flex-col gap-3">

    {{-- Gambar Barang --}}
    <div class="w-full h-32 bg-[#D9D9D9] rounded-lg overflow-hidden shrink-0">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        @endif
    </div>

    {{-- Info Text --}}
    <div class="flex flex-col gap-0.5 cursor-default">
        <h3 class="text-base font-bold text-judul tracking-tight truncate">{{ $title ?: 'Nama Barang' }}</h3>
        <p class="text-xs text-subtext font-medium truncate">{{ $category ?: 'Kategori' }}</p>
    </div>

    {{-- Badge --}}
    <div class="-mx-1">
        <x-badge label1="Tersedia" :label2="$stock" class="cursor-default p-2 text-[4px]" />
    </div>

    {{-- Controls Jumlah Pinjam --}}
    <div class="flex items-center justify-between mt-1">
        <span class="text-[11px] font-bold tracking-wider uppercase cursor-default text-judul">Jumlah Pinjam</span>

        <div class="flex items-center gap-2">
            <button
                type="button"
                @click="kurang()"
                :disabled="maxStock < 1"
                class="flex items-center justify-center w-8 h-8 bg-primary-hover text-white rounded-md hover:bg-primary active:scale-95 transition-all disabled:opacity-50"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </button>

            <span class="font-semibold text-sm w-4 text-center text-judul cursor-default" x-text="quantity"></span>

            <button
                type="button"
                @click="tambah()"
                :disabled="quantity >= maxStock"
                class="flex items-center justify-center w-8 h-8 bg-primary-hover text-white rounded-md hover:bg-primary active:scale-95 transition-all disabled:opacity-50"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-stretch gap-2 mt-1">
        <x-action-button
            href="{{ route('user.peminjaman.detail') }}"
            type="view"
            as="button"
            class="!w-10 !h-10 !text-white !bg-primary-hover hover:!bg-primary !rounded-lg shrink-0"
        />

        <x-button
            type="button"
            :disabled="$stock < 1"
            class="flex-1 !px-2 !py-2 bg-primary-hover cursor-default text-white hover:bg-primary !text-sm font-bold !rounded-lg justify-center font-sans transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            @click="pilihBarang()"
        >
            <span x-show="!dipilih">Pilih Barang</span>
            {{-- Ubah teks jadi 'Update' jika state dipilih aktif agar user tahu mereka bisa simpan perubahan jumlah --}}
            <span x-show="dipilih">Update Jumlah</span> 
        </x-button>
    </div>
</div>