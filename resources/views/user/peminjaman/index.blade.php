@extends('layouts.app')

@section('title', 'Daftar Peminjaman Inventaris')

@section('content')

<div class="space-y-8 p-8">
    {{-- Heading --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-extrabold text-judul">
                Daftar Peminjaman Inventaris
            </h1>
            <p class="text-dark-grey text-lg">
                Kelola dan pantau status peminjaman inventaris Anda.
            </p>
        </div>
        <x-button href="{{ route('user.peminjaman.create') }}">
            Tambah Peminjaman
        </x-button>
    </div>

    {{-- Statistik --}}
    <div class="space-y-5">
        <h1 class="text-xl font-bold tracking-[1.5px] text-dark-grey">
            STATISTIK PEMINJAMAN
        </h1>
        <div class="flex gap-6">
            <x-statecard
                title="Total Aktif"
                :value="$suratAktif"
                label="Peminjaman"
                border="border-l-primary-hover"
                iconBg="bg-primary-hover/10"
            >
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Total Selesai"
                :value="$suratSelesai"
                label="Peminjaman"
                border="border-l-primary-hover"
                iconBg="bg-primary-hover/10"
            >
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Total Diproses"
                :value="$suratPending"
                label="Peminjaman"
                border="border-l-status-yellow"
                iconBg="bg-status-yellow/10"
            >
                <x-icons.totalpending/>
            </x-statecard>
            <x-statecard
                title="Total Ditolak"
                :value="$suratReject"
                label="Peminjaman"
                border="border-l-status-red"
                iconBg="bg-status-red/10"
            >
                <x-icons.totaltolak/>
            </x-statecard>
        </div>
    </div>

    <x-container>
        <div class="p-8 space-y-6">
            <h1 class="text-xl font-bold text-dark-grey">Cari Peminjaman</h1>
            <form method="GET">
                <div class="grid grid-cols-[1fr_250px] gap-6">
                    <x-search-bar
                        name="search"
                        :showFilter="false"
                        placeholder="Masukkan Nama Peminjaman..."
                        :value="request('search')"
                    />
                    <x-select name="status" label="Status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" @selected(request('status') == 'aktif')>
                            Aktif
                        </option>
                        <option value="selesai" @selected(request('status') == 'selesai')>
                            Selesai
                        </option>
                        <option value="pending" @selected(request('status') == 'pending')>
                            Pending
                        </option> 
                        <option value="ditolak" @selected(request('status') == 'ditolak')>
                            Ditolak
                        </option>
                    </x-select>
                </div>
            </form>
        </div>
    </x-container>

    <x-container>
        <x-table
            :headers="['No', 'Nama Kegiatan', 'ID Pinjam', 'Tanggal Pinjam', 'Estimasi Kembali', 'Status', 'Tujuan', 'Aksi']"
            :cols="['70px', '1fr', '0.9fr', '0.5fr', '0.5fr', '0.7fr', '0.5fr', '140px']"
            :data="$peminjaman"
            headerBg="bg-primary-hover"
            headerClass="text-bg-light font-bold text-base uppercase"
        >
            @foreach($peminjaman as $surat)
                <x-table-row>
                    <div class="justify-center text-dark-grey">
                        {{ $loop->iteration }}
                    </div>
                    <div class="font-bold break-all">
                        {{ $surat->acara }}
                    </div>
                    <div>
                        <span class="bg-[#EEF0FF] text-primary-hover rounded-xl px-4 py-2 font-bold break-all">
                            {{ $surat->nomor }}
                        </span> 
                    </div>
                    <div class="justify-center">
                        {{ $surat->tanggal_peminjaman->format('d M Y') }}
                    </div>
                    <div class="justify-center">
                        {{ $surat->tanggal_kembali->format('d M Y') }}
                    </div>
                    <div class="justify-center">
                        @php
                            $label = match (true) {
                                is_null($surat->status_peminjaman) => 'Pending',
                                $surat->status_peminjaman == 0 => 'Ditolak',
                                $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan != 1 => 'Pending',
                                $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && now()->lt($surat->tanggal_peminjaman) => 'Diterima',
                                $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && now()->between($surat->tanggal_peminjaman, $surat->tanggal_kembali) => 'Aktif',
                                $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && now()->gt($surat->tanggal_kembali) => 'Selesai',
                                default => 'Pending',
                            };
                        @endphp

                        <x-status-card :status="$surat->status_peminjaman" :ttd="$surat->tandatangan_pimpinan">
                            {{ $label }}
                        </x-status-card>
                    </div>
                    <div class="justify-center text-primary font-bold">
                        {{ $surat->detailPeminjaman->first()?->inventaris?->user?->organization?->name?? '-' }}
                    </div>
                    <div class="justify-center">
                        <x-take-action 
                            :viewUrl="route('user.peminjaman.detail-surat', $surat)"
                        />
                    </div>
                </x-table-row>
            @endforeach
        </x-table>
    </x-container>
</div>
@endsection