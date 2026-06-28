@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')
<div class="m-5">
<x-header-dashboard />

<x-container>
    {{-- ===== HEADER ===== --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold m-5 mb-1 pt-5">Surat Masuk</h1>
            <p class="ml-5 mt-0 text-gray-600">Daftar Surat Peminjaman Inventaris</p>
        </div>
        <div class="flex justify-end items-center pr-4 pt-5">
            <button class="flex items-center gap-2 px-3 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" />
                </svg>
            </button>
        </div>
    </div>

    {{-- ===== FILTER ===== --}}
    <div class="m-5">
        <form method="GET" action="{{ route('petinggi.surat.index') }}" class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nomor surat, perihal, atau nama peminjam..."
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-4 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary transition">
            </div>

            {{-- Filter Status --}}
            <select
                name="status"
                class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:border-primary focus:ring-1 focus:ring-primary transition w-full sm:w-44">
                <option value="">Semua Status</option>
                <option value="1"       {{ request('status') === '1'       ? 'selected' : '' }}>Diterima</option>
                <option value="pending" {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="0"       {{ request('status') === '0'       ? 'selected' : '' }}>Ditolak</option>
            </select>

            {{-- Tombol --}}
            <button type="submit"
                class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition">
                Filter
            </button>

            {{-- Reset (muncul jika ada filter aktif) --}}
            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('petinggi.surat.index') }}"
                class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition text-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- ===== TABEL ===== --}}
    <div class="m-5">
        <x-table
            :headers="['No', 'Nomor Surat', 'Perihal', 'Nama Kegiatan', 'Tanggal Kirim', 'Status', 'Aksi']"
            :cols="['60px', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '180px']"
            :data="$surats"
            headerBg="bg-primary-hover/10"
            headerClass="text-primary font-bold text-sm uppercase"
            bg="bg-white overflow-hidden">

            @forelse($surats as $surat)
            <x-table-row>
                <div>{{ $loop->iteration }}</div>
                <div class="font-bold justify-start">
                    {{ $surat->nomor }}
                </div>
                <div class="justify-start">
                    {{ $surat->perihal_peminjaman }}
                </div>
                <div class="justify-center">
                    {{ $surat->acara }}
                </div>
                <div class="justify-center">
                    {{ $surat->tanggal_peminjaman->format('d M Y') }}
                </div>
                <div class="justify-center">
                    <x-status-card :status="$surat->getRawOriginal('tandatangan_pimpinan')" />
                </div>
                <div class="flex justify-center items-center gap-3">
                    <x-action-button
                        type="view"
                        as="a"
                        :href="route('petinggi.surat.show', $surat)"
                    />
                    <x-action-button
                        type="delete"
                        as="a"
                        :href="route('petinggi.surat.show', $surat)"
                    />
                </div>
            </x-table-row>

            @empty
            {{-- ===== EMPTY STATE ===== --}}
            <div class="flex flex-col items-center justify-center py-16 text-center col-span-full">
                <div class="rounded-full bg-gray-100 p-5 mb-4">
                    <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>

                @if(request()->hasAny(['search', 'status']))
                    <p class="text-gray-700 font-semibold text-sm">Tidak ada hasil ditemukan</p>
                    <p class="text-gray-400 text-xs mt-1 mb-4">
                        Coba ubah kata kunci atau filter yang digunakan
                    </p>
                    <a href="{{ route('petinggi.surat.index') }}"
                        class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary-hover transition">
                        Reset Filter
                    </a>
                @else
                    <p class="text-gray-700 font-semibold text-sm">Belum ada surat masuk</p>
                    <p class="text-gray-400 text-xs mt-1">Surat peminjaman inventaris akan tampil di sini</p>
                @endif
            </div>
            @endforelse

        </x-table>

        {{-- Pagination --}}
        @if($surats->hasPages())
        <div class="mt-4">
            {{ $surats->links() }}
        </div>
        @endif
    </div>

</x-container>
</div>
@endsection