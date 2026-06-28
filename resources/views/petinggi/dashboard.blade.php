@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="m-5">
    <x-header-dashboard/>

    <div class="grid grid-cols-4 gap-4 mb-10">
            <x-statecard
                title="Total Aktif"
                :value="$suratAprove"
                label="Peminjaman"
                border="border-l-primary-hover"
                iconBg="bg-primary-hover/10"
            >
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Total Selesai"
                :value="$suratDone"
                label="Peminjaman"
                border="border-l-status-green"
                iconBg="bg-status-green/10"
            >
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Total Pending"
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

    <x-container>
        <h1 class="text-xl font-bold m-4 mb-2 pt-5">Surat Masuk</h1>
        <p class="m-4 mt-0 text-gray-600">Daftar Surat Peminjaman Inventaris</p>
        <div  class="m-4">
            <x-search-bar></x-search-bar>
        </div>
        <x-table
            :headers="['No', 'Nomor Surat', 'Perihal', 'Nama Kegiatan', 'Tanggal Kirim', 'Status', 'Aksi']"
            :cols="['60px', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '180px']"
            :data="$surats"
            headerBg="bg-primary-hover/10"
            headerClass="text-primary font-bold text-sm uppercase"
            bg="bg-white overflow-hidden"
        >
                @foreach($surats as $surat)
                    <x-table-row>
                        <div>{{ $loop->iteration }}</div>
                        <div class="font-bold justify-start">
                            {{ $surat->nomor }}
                        </div>
                        <div class="justify-start">
                            {{ $surat->perihal_peminjaman }}
                        </div>
                        <div class="justify-center">
                            {{ $surat->nama_kegiatan }}
                        </div>
                        <div class="justify-center">
                            {{ $surat->tanggal_peminjaman->format('d M Y') }}
                        </div>
                        <div class="justify-center">
                            <x-status-card :status="$surat->status_peminjaman"/>
                        </div>
                        <div>
                            <x-take-action/>
                        </div>
                    </x-table-row>
                @endforeach
        </x-table>
    </x-container>
</div>
@endsection