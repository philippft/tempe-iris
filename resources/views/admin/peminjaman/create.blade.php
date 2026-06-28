@extends('layouts.app')

@section('title', 'Form Peminjaman Inventaris')

@section('content')

<x-header-page class="m-0" title="Form Pengajuan Peminjaman"/>

<div class="flex flex-col gap-6 px-10 py-6">

    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-judul tracking-tight">Daftar Barang Inventaris</h1>
        <p class="text-base font-medium text-subtext">Pilih tujuan peminjaman dan barang yang ingin dipinjam</p>
    </div>

    {{-- Form dialihkan ke route penampung detail --}}
    <form action="{{ route('admin.peminjaman.detail') }}" method="POST" class="flex flex-col gap-8"
        x-data="{
            barangPinjaman: JSON.parse(localStorage.getItem('cart_peminjaman') || '[]'),
            idTujuan: '{{ request('id_tujuan', '') }}',

            init() {
                // Auto-save ke localStorage setiap kali keranjang berubah
                this.$watch('barangPinjaman', (value) => {
                    localStorage.setItem('cart_peminjaman', JSON.stringify(value));
                });
            },

            tambahKeDaftar(event) {
                let dataBarang = event.detail; // Ekspektasi data: { id: 1, nama: '...', jumlah: 2 }
                if (!dataBarang.id) return;

                let index = this.barangPinjaman.findIndex(b => b.id === dataBarang.id);

                if (index >= 0) {
                    this.barangPinjaman[index].jumlah = parseInt(dataBarang.jumlah);
                    alert('Jumlah ' + dataBarang.nama + ' diperbarui menjadi ' + dataBarang.jumlah);
                } else {
                    this.barangPinjaman.push({
                        id: dataBarang.id,
                        nama: dataBarang.nama,
                        jumlah: parseInt(dataBarang.jumlah)
                    });
                    alert(dataBarang.nama + ' berhasil ditambahkan!');
                }
            },

            hapusDariDaftar(id) {
                this.barangPinjaman = this.barangPinjaman.filter(b => b.id !== id);
            },

            submitForm(event) {
                if (!this.idTujuan) {
                    event.preventDefault();
                    alert('Silakan pilih tujuan peminjaman terlebih dahulu.');
                    return;
                }
                if (this.barangPinjaman.length === 0) {
                    event.preventDefault();
                    alert('Silakan pilih minimal satu barang sebelum melanjutkan peminjaman.');
                    return;
                }
                // Hapus localStorage hanya saat submit berhasil
                localStorage.removeItem('cart_peminjaman');
            }
        }"
        @barang-dipilih.window="tambahKeDaftar($event)"
        @submit="submitForm($event)"
    >
        @csrf

        {{-- 1. Box Tujuan Peminjaman --}}
        <div class="bg-white border border-border-custom rounded-[24px] p-6 shadow-sm">
            <x-select 
                name="id_tujuan" 
                label="Pilih Tujuan Peminjaman"
                {{-- Gunakan @change milik AlpineJS --}}
                @change="
                    const url = new URL(window.location.href);
                    if ($event.target.value) {
                        url.searchParams.set('id_tujuan', $event.target.value);
                    } else {
                        url.searchParams.delete('id_tujuan');
                    }
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                "
            >
                <option value="">-- Pilih Tujuan --</option>
                @foreach ($tujuan as $t)
                    <option value="{{ $t->id }}" {{ request('id_tujuan') == $t->id ? 'selected' : '' }}>
                        {{ $t->organization_name ?? 'Tidak Diketahui' }}
                    </option>
                @endforeach
            </x-select>
        </div>

        {{-- 2. Search & Kategori Row --}}
        <div class="flex items-end gap-4">
            <div class="flex-1"
                @keydown.enter.prevent="
                    const url = new URL(window.location.href);
                    if ($event.target.value) {
                        url.searchParams.set('search', $event.target.value);
                    } else {
                        url.searchParams.delete('search');
                    }
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                "
            >
                <x-input
                    id="input-search"
                    name="search"
                    value="{{ request('search') }}"
                    label="Cari Barang"
                    placeholder="Masukkan Nama Barang dan Tekan Enter..."
                />
            </div>

            <div class="w-[280px]">
                <x-select name="category_id" label="Kategori"
                    value="{{ request('category_id') }}"
                    {{-- Gunakan @change milik AlpineJS --}}
                    @change="
                        const url = new URL(window.location.href);
                        if ($event.target.value) {
                            url.searchParams.set('category_id', $event.target.value);
                        } else {
                            url.searchParams.delete('category_id');
                        }
                        url.searchParams.delete('page');
                        window.location.href = url.toString();
                    "
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories ?? [] as $cat )
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </div>

        @php
            // Custom pagination built-in dari data collection $inventaris
            $currentPage = request()->get('page', 1);
            $perPage = 8;
            $currentItems = $inventaris->slice(($currentPage - 1) * $perPage, $perPage);
            $paginatedInventaris = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentItems,
                $inventaris->count(),
                $perPage,
                $currentPage,
                [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]
            );
        @endphp

        {{-- 3. Grid Daftar Barang (Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4">
            @forelse ($inventaris as $item)
                {{-- Pastikan komponen x-card-item melempar custom event dispatch 'barang-dipilih' dengan membawa payload id, nama, dan jumlah --}}
                <x-card-item
                    :id="$item->id"
                    :title="$item->nama"
                    :category="$item->category->name ?? 'Umum'"
                    :stock="$item->stok_tersedia"
                    :image="$item->gambar ? asset('storage/' . $item->gambar) : null"
                />
            @empty
                <div class="col-span-full bg-white border border-slate-100 rounded-2xl py-12 text-center text-xs text-slate-400 font-normal shadow-sm">
                    @if(request('id_tujuan'))
                        Tidak ditemukan barang inventaris yang sesuai dengan filter pencarian pada organisasi ini.
                    @else
                        Silakan pilih tujuan organisasi terlebih dahulu untuk memuat daftar barang inventaris.
                    @endif
                </div>
            @endforelse
        </div>

        {{-- 4. Pagination --}}
        @if($inventaris->count() > $perPage)
            <div class="bg-white border border-border-custom rounded-[24px] shadow-sm">
                <x-pagination :data="$paginatedInventaris" />
            </div>
        @endif

        {{-- Hidden input yang dikirim ke Controller --}}
        <template x-for="(barang, index) in barangPinjaman" :key="'hidden-' + barang.id">
            <div>
                <input type="hidden" :name="'items['+index+'][id_inventaris]'" :value="barang.id">
                <input type="hidden" :name="'items['+index+'][qty]'" :value="barang.jumlah">
            </div>
        </template>

        {{-- 5. Tombol Lanjut Peminjaman --}}
        <div class="flex justify-end mt-2">
            <button
                type="submit"
                :disabled="barangPinjaman.length === 0"
                :class="barangPinjaman.length === 0
                    ? 'bg-slate-300 text-slate-500 cursor-not-allowed'
                    : 'bg-primary-hover text-white hover:bg-primary cursor-pointer'"
                class="!px-6 !py-4 rounded-xl font-bold shadow-lg transition-colors"
            >
                Lanjut Peminjaman
            </button>
        </div>

    </form>
</div>
@endsection