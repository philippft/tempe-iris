@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<x-header-dashboard/>

<div class="space-y-8">
    <h1 class="text-xl font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h1>
    <div class="flex w-full justify-start gap-6">
        <x-statecard
            title="Total Aktif"
            :value="$totalAktif"
            label="Peminjaman"
            border="border-l-primary-hover"
            iconBg="bg-primary-hover/10"
        >
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Pending"
            :value="$totalPending"
            label="Peminjaman"
            border="border-l-status-yellow"
            iconBg="bg-status-yellow/10"
        >
            <x-icons.totalpending/>
        </x-statecard>
        <x-statecard
            title="Total Ditolak"
            :value="$totalTolak"
            label="Peminjaman"
            border="border-l-status-red"
            iconBg="bg-status-red/10"
        >
            <x-icons.totaltolak/>
        </x-statecard>
    </div>

    <x-container>
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

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">
        Logout
    </button>
</form>

@endsection