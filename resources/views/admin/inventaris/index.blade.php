@extends('layouts.app')

@section('title', 'Manajemen Inventaris') 

@section('content')

<div class="p-8 space-y-10">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-4xl font-extrabold text-judul">Manajemen Inventaris</h3>
            <p class="text-base text-dark-grey font-medium">Kelola daftar barang inventaris yang dapat dipinjam</p>
        </div>
        <a href="{{ route('admin.inventaris.create') }}" class="text-white bg-primary-hover px-4 py-2.5 text-xs font-bold rounded-lg shadow-sm hover:bg-primary transition flex items-center gap-2">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 15H11V11H15V9H11V5H9V9H5V11H9V15ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="white"/>
            </svg>
            Tambah Inventaris
        </a>
    </div>
    <div class="space-y-4">
        <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">STATISTIK BARANG INVENTARIS</h2>
        <div class="flex flex-wrap w-full justify-start gap-6">
            <x-statecard    
                title="Total Inventaris"
                :value="$totalStok ?? 0"
                label="Barang"
                border="border-l-primary-hover"
                iconBg="bg-primary/10"
                > 
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Inventaris Aktif"
                :value="$stokAktif ?? 0"
                label="Barang"
                border="border-l-status-green"
                iconBg="bg-status-green/10"
            > 
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Inventaris Tidak Aktif"
                :value="$stokTidakAktif ?? 0"
                label="Barang"
                border="border-l-status-red"
                iconBg="bg-status-red/10"
            > 
                <x-icons.totaltolak/>
            </x-statecard>
        </div>
    </div>

    <!-- ini placeholdernya search sama kategori -->
    <div class="rounded-2xl border border-border-custom bg-white p-5 shadow-md">
        <form action="{{ request()->url() }}" method="GET" class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="flex-1 max-w-3xl">
                <label class="block text-xs font-bold text-dark-grey uppercase tracking-wider mb-2">Cari Barang</label>
                <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="#70787C"/>
                    </svg>
                </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="block w-full rounded-xl border border-border-custom bg-bg-dark py-2.5 pl-10 pr-4 text-sm text-dark-grey focus:border-primary-hover focus:ring-primary-hover transition"
                        placeholder="Masukkan ID Barang atau Nama Barang...">
                </div>
            </div>

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-dark-grey uppercase tracking-wider mb-2">Kategori</label>
                <select name="category" onchange="this.form.submit()"
                    class="block w-full rounded-xl border border-border-custom bg-bg-dark px-4 py-2.5 text-sm text-dark-grey focus:border-primary-hover focus:ring-primary-hover transition">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <form action="{{ route('admin.inventaris.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <x-container>
            <x-table
                :headers="['NO', 'Gambar', 'Nama Barang', 'Kategori', 'aktif', 'tidak aktif', 'aksi']"
                :cols="['60px', '120px', '1.5fr', '1fr', '1fr', '1fr', '140px']"
                :data="$inventaris"
                headerBg="bg-primary-hover"
                headerClass="text-white font-bold text-sm uppercase"
                bg="bg-white overflow-hidden"
                >
                @php 
                    $no = ($inventaris->currentPage() - 1) * $inventaris->perPage(); 
                    $status = null; 
                @endphp

                @forelse($inventaris as $item)
                    <x-table-row>
                        <div class="justify-center font-medium">
                            {{ str_pad(++$no, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="justify-center">
                            <div class="h-16 w-24 shrink-0 overflow-hidden rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center">
                                @if($item->image && file_exists(public_path($item->image)))
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        <div class="justify-start font-bold text-judul wrap-break-words pr-2 text-base">
                            {{ $item->nama }}
                        </div>
                        
                        <div class="justify-start">
                            <span class="inline-flex text-center items-center rounded-full bg-bg-dark px-3 py-1 text-sm font-semibold text-primary-hover ring-1 ring-inset ring-border-custom/10">
                                {{ $item->category->name ?? 'Umum' }}
                            </span>
                        </div>
                        
                        <div class="justify-center font-medium text-dark-grey text-base">
                            {{ $item->stok_aktif }} Barang
                        </div>
                        
                        <div class="justify-center font-medium text-dark-grey text-base">
                            {{ $item->stok_tidak_aktif }} Barang
                        </div>
                        
                        <!-- <div class="justify-center">
                            <div class="bg-status-green inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                                Aktif
                            </div>
                        </div> -->
                        <div class="justify-center flex gap-2">
                            <x-action-button type="view" title="Lihat Data" as="a" href="{{ route('admin.inventaris.show', ['inventaris' => $item->id, 'status' => $status]) }}"/>
                                <form action="{{ route('admin.inventaris.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        title="Hapus Data">
                                        <x-action-button type="delete" as="a" href="">
                                    </button>
                                </form>
                            </div>
                        </x-table-row>
                        @empty
                <x-table-empty title="Tidak ada Inventaris" message="Saat ini belum ada data inventaris yang tersedia atau tidak ada inventaris yang cocok dengan pencarian Anda."/>
                @endforelse
            </x-table>
        </x-container>
    </form>
</div>   
@endsection