@extends('layouts.app')

@section('title', 'Manajemen Inventaris') 

@section('content')
<div class="p-8 space-y-10">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-4xl font-extrabold text-judul">Manajemen Inventaris</h3>
            <p class="text-base text-dark-grey font-medium">Kelola daftar barang inventaris yang dapat dipinjam</p>
        </div>
        <a href="{{ route('admin.inventaris.create') }}"
                    class="text-white bg-primary-hover px-4 py-2.5 text-xs font-bold rounded-lg shadow-sm hover:bg-primary transition flex items-center gap-2">
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

    <!-- ini placeholdernya philip yang search -->
    <div class="rounded-2xl border border-border-custom bg-white p-5 shadow-sm">
        <form action="{{ request()->url() }}" method="GET"
            class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="flex-1 max-w-2xl">
                <label class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Cari
                    Barang</label>
                <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] py-2.5 pl-10 pr-4 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition"
                        placeholder="Masukkan ID Barang atau Nama Barang...">
                </div>
            </div>

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Kategori</label>
                <select name="category" onchange="this.form.submit()"
                    class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    
    <x-container>
            <x-table
                :headers="['NO', 'Gambar', 'Nama Barang', 'Kategori', 'stok', 'status', 'aksi']"
                :cols="['60px', '1fr', '1.2fr', '1fr', '1fr', '1fr', '0.8fr']"
                data=""
                headerBg="bg-primary-hover"
                headerClass="text-white font-bold text-sm uppercase"
                bg="bg-white overflow-hidden"
            >
        
            <x-table-row>
                <div>
                   
                </div>
            </x-table-row>
            </x-table>
        </x-container>

    <!-- batas batas hapus nanti ke bawah ini -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 bg-[#F8FAFC]">
    
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-[#0F172A]">Manajemen Inventaris</h1>
                    <p class="mt-1 text-sm text-[#64748B]">Kelola daftar barang inventaris yang dapat dipinjam</p>
                </div>
                <a href="{{ route('admin.inventaris.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#005B60] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#00484C] transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Inventaris
                </a>
            </div>
    
            <div class="mb-8 flex flex-col gap-6 md:flex-row">
                <div
                    class="flex-1 relative rounded-2xl border-l-[6px] border-[#0A6B7B] bg-white p-6 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#64748B]">Total Inventaris</p>
                        <p class="mt-2 text-4xl font-bold text-[#0F172A]">{{ $totalStok ?? 0 }} <span
                                class="text-sm font-medium text-[#94A3B8]">Barang</span></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-2 text-[#0A6B7B]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                </div>
    
                <div
                    class="flex-1 relative rounded-2xl border-l-[6px] border-[#22C55E] bg-white p-6 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#64748B]">Inventaris Aktif</p>
                        <p class="mt-2 text-4xl font-bold text-[#0F172A]">{{ $stokAktif ?? 0 }} <span
                                class="text-sm font-medium text-[#94A3B8]">Barang</span></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-2 text-[#22C55E]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                </div>
    
                <div
                    class="flex-1 relative rounded-2xl border-l-[6px] border-[#EF4444] bg-white p-6 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#64748B]">Inventaris Tidak Aktif</p>
                        <p class="mt-2 text-4xl font-bold text-[#0F172A]">{{ $stokTidakAktif ?? 0 }} <span
                                class="text-sm font-medium text-[#94A3B8]">Barang</span></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-2 text-[#EF4444]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                    </div>
                </div>
            </div>
    
            <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <form action="{{ request()->url() }}" method="GET"
                    class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div class="flex-1 max-w-2xl">
                        <label class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Cari
                            Barang</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] py-2.5 pl-10 pr-4 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition"
                                placeholder="Masukkan ID Barang atau Nama Barang...">
                        </div>
                    </div>
    
                    <div class="w-full md:w-64">
                        <label class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Kategori</label>
                        <select name="category" onchange="this.form.submit()"
                            class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
    
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left text-sm">
                        <thead class="bg-[#0B5C66] text-xs font-bold uppercase tracking-wider text-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">No</th>
                                <th scope="col" class="px-6 py-4 text-center">Gambar</th>
                                <th scope="col" class="px-6 py-4">Nama Barang</th>
                                <th scope="col" class="px-6 py-4">Kategori</th>
                                <th scope="col" class="px-6 py-4">Stok</th>
                                <th scope="col" class="px-6 py-4 text-center">Status</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @php $no = 0; $status = null; @endphp)
                            @forelse($inventaris as $item)
                            @if(($item->stok_aktif ?? 0) > 0)
                            @php $status = 1; @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">
                                    {{ str_pad(++$no, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 flex justify-center">
                                    <div
                                        class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center">
                                        @if($item->image && file_exists(public_path($item->image)))
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->nama }}"
                                            class="h-full w-full object-cover">
                                        @else
                                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->nama }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/10">
                                        {{ $item->category->name ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-600">{{ $item->stok_aktif }}
                                    Barang</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#22C55E] px-3 py-1 text-xs font-bold text-white uppercase tracking-wider">
                                        Aktif
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.inventaris.show', ['inventaris' => $item->id, 'status' => $status]) }}"
                                            class="rounded-lg bg-slate-50 p-2 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition"
                                            title="Lihat Data">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.inventaris.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-lg bg-slate-50 p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 transition"
                                                title="Hapus Data">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
    
                            @if(($item->stok_tidak_aktif ?? 0) > 0)
                            @php $status = 0; @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">
                                    {{ str_pad(++$no, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 flex justify-center">
                                    <div
                                        class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center">
                                        @if($item->image && file_exists(public_path($item->image)))
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->nama }}"
                                            class="h-full w-full object-cover">
                                        @else
                                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->nama }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/10">
                                        {{ $item->category->name ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-600">
                                    {{ $item->stok_tidak_aktif }} Barang</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#EF4444] px-3 py-1 text-xs font-bold text-white uppercase tracking-wider">
                                        Tidak Aktif
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.inventaris.show', ['inventaris' => $item->id, 'status' => $status]) }}"
                                            class="rounded-lg bg-slate-50 p-2 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition"
                                            title="Edit Data">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.inventaris.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-lg bg-slate-50 p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 transition"
                                                title="Hapus Data">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">
                                    Data inventaris tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
                <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-sm text-slate-500">
                        Menampilkan <span class="font-semibold text-slate-800">{{ $inventaris->count() }}</span> dari <span
                            class="font-semibold text-slate-800">{{ $totalBarang ?? 0 }}</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button
                            class="px-3 py-1 border border-gray-200 rounded-lg text-slate-400 hover:bg-slate-50 transition"
                            disabled>&lt;</button>
                        <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg font-semibold">1</button>
                        <button
                            class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 hover:bg-slate-50 transition">2</button>
                        <button
                            class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 hover:bg-slate-50 transition">3</button>
                        <button
                            class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 hover:bg-slate-50 transition">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    
</div>

@endsection