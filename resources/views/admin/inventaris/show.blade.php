@extends('layouts.app')

@section('title', 'Detail Inventaris') 

@section('content')
<x-header-page title="Detail Inventaris" :href="route('admin.inventaris.index')"/>

<div class="p-8 sm:px-6 space-y-9">
    <div class="flex gap-4 flex-row items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-primary-hover">Detail Barang</h2>
            <p class="text-sm text-dark-grey font-medium mt-1">Lihat detail informasi barang {{ $inventaris->nama }}</p>
        </div>
        <!-- <div>
            @if(($inventaris->stocks === 'aktif') || ($inventaris->stocks === 1))
            <x-badge label1="aktif"/>
            @else
            <x-badge label1="tidak aktif" variant="red"/>
            @endif
        </div>     -->
    </div>    
    <div class="flex justify-center">
        <div
            class="w-96 overflow-hidden rounded-2xl bg-bg-dark border border-border-custom flex items-center justify-center shadow-inner">
            @if($inventaris->image && file_exists(public_path($inventaris->image)))
            <img src="{{ asset($inventaris->image) }}" alt="{{ $inventaris->nama }}" class="w-full h-full object-cover">
            @else
            <div class="h-96 flex items-center justify-center">
                <svg class="h-16 w-16 justify-center items-center text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>

            </div>
            @endif
        </div>
    </div>

    <div class="bg bg-white rounded-2xl  border border-border-custom/50 p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-primary-hover pb-3 border-b border-border-custom">
            Informasi Barang
        </h1>
        <div class="space-y-6">
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Nama barang
                </h3>
                <h1 class="text-lg font-semibold text-judul capitalize">
                   {{ $inventaris->nama }}
                </h1>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Kategori
                </h3>
                <h1 class="text-lg font-semibold text-judul capitalize">
                   {{ $inventaris->category->name ?? 'Umum' }}
                </h1>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Stok Barang
                </h3>
                <h1 class="text-lg font-semibold text-judul capitalize">
                   {{ $inventaris->stocks->count() }} Pcs
                </h1>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Deskripsi
                </h3>
                <h1 class="text-lg font-semibold text-judul">
                   {{ $inventaris->deskripsi ?? 'Tidak ada deskripsi atau catatan tambahan untuk barang ini.' }}
                </h1>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.inventaris.edit', $inventaris->id) }}" class="block w-full text-center rounded-xl bg-status-yellow py-4 text-2xl font-bold text-white shadow-lg hover:bg-[#EAAA08] transition">Perbarui Data</a>
    
    <div>
        <h2 class="text-3xl font-bold text-primary-hover">Riwayat Peminjaman</h2>
        <p class="text-sm text-dark-grey font-medium mt-1">Lihat riwayat peminjaman dari inventaris {{ $inventaris->nama }}</p>
    </div>

    <x-container>
        <x-table
            :headers="['NO', 'Nama Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali', 'status']"
            :cols="['60px', '1fr', '1fr', '1fr', '140px']"
            :data="$inventaris"
            headerBg="bg-primary-hover"
            headerClass="text-white font-bold text-sm uppercase"
            bg="bg-white overflow-hidden"
        >
            @forelse($inventaris->detailPeminjaman as $index => $detail)
                @php
                    $surat = $detail->surat;
                @endphp

                @if($surat)
                <x-table-row>

                    <div class="justify-center font-medium text-dark-grey">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="justify-start font-semibold text-judul">
                        {{ $surat->user->name ?? '-' }}
                    </div>

                    @php
                        $kegiatan = $surat->kegiatan->first();
                    @endphp
                    <div class="justify-center">
                        @if($kegiatan)
                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </div>

                    <div class="justify-center">
                        @if($surat->tanggal_pengembalian)
                            {{ \Carbon\Carbon::parse($surat->tanggal_pengembalian)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </div>

                    <div class="justify-center">
                        @php
                            $status = '';

                            if (is_null($surat->status_peminjaman)) {
                                $status = 'pending';
                            } elseif ($surat->status_peminjaman == 0) {
                                $status = 'ditolak';
                            } elseif ($surat->tanggal_kembali && \Carbon\Carbon::parse($surat->tanggal_kembali)->isPast()) {
                                $status = 'selesai';
                            } else {
                                $status = 'dipinjam';
                            }
                        @endphp

                        @switch($status)
                            @case('pending')
                                <span class="bg-primary-hover px-4 py-2 rounded-full text-white text-xs font-bold uppercase">
                                    Pending
                                </span>
                                @break

                            @case('ditolak')
                                <span class="bg-status-red px-4 py-2 rounded-full text-white text-xs font-bold uppercase">
                                    Ditolak
                                </span>
                                @break

                            @case('selesai')
                                <span class="bg-status-green px-4 py-2 rounded-full text-white text-xs font-bold uppercase">
                                    Selesai
                                </span>
                                @break

                            @default
                                <span class="bg-status-yellow px-4 py-2 rounded-full text-white text-xs font-bold uppercase">
                                    Dipinjam
                                </span>
                        @endswitch
                    </div>

                </x-table-row>
                @endif

            @empty
                <x-table-empty
                    title="Tidak ada Riwayat"
                    message="Saat ini belum ada riwayat peminjaman inventaris."
                />
            @endforelse
        </x-table>
    </x-container>
</div>

@endsection